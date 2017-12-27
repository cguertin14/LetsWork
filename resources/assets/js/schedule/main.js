$(document).ready(function () {
    function PlacerHoraire(){
        var previousWidth = 0;
        var transitionEnd = 'webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend';
        var transitionsSupported = ( $('.csstransitions').length > 0 );
        //if browser does not support transitions - use a different event to trigger them
        if( !transitionsSupported ) transitionEnd = 'noTransition';

        //should add a loding while the events are organized

        function SchedulePlan( element ) {
            this.element = element;
            this.timeline = this.element.find('.timeline');
            this.timelineItems = this.timeline.find('li');
            this.timelineItemsNumber = this.timelineItems.length;
            this.timelineStart = getScheduleTimestamp(this.timelineItems.eq(0).text());
            //need to store delta (in our case half hour) timestamp
            this.timelineUnitDuration = getScheduleTimestamp(this.timelineItems.eq(1).text()) - getScheduleTimestamp(this.timelineItems.eq(0).text());

            this.eventsWrapper = this.element.find('.events');
            this.eventsGroup = this.eventsWrapper.find('.events-group');
            this.singleEvents = this.eventsGroup.find('.single-event');
            this.eventSlotHeight = this.eventsGroup.eq(0).children('.top-info').outerHeight();

            this.modal = this.element.find('.event-modal');
            this.modalHeader = this.modal.find('.header');
            this.modalHeaderBg = this.modal.find('.header-bg');
            this.modalBody = this.modal.find('.body');
            this.modalBodyBg = this.modal.find('.body-bg');
            this.modalMaxWidth = 800;
            this.modalMaxHeight = 480;

            this.animating = false;

            this.initSchedule();
        }

        SchedulePlan.prototype.initSchedule = function() {
            this.scheduleReset();
            this.initEvents();
            this.placeEvents();
        };

        SchedulePlan.prototype.scheduleReset = function() {
            var mq = this.mq();
            if( mq == 'desktop' && !this.element.hasClass('js-full') ) {
                //in this case you are on a desktop version (first load or resize from mobile)
                this.eventSlotHeight = this.eventsGroup.eq(0).children('.top-info').outerHeight();
                this.element.addClass('js-full');
                this.placeEvents();
                this.element.hasClass('modal-is-open') && this.checkEventModal();
            } else if(  mq == 'mobile' && this.element.hasClass('js-full') ) {
                //in this case you are on a mobile version (first load or resize from desktop)
                this.element.removeClass('js-full loading');
                this.eventsGroup.children('ul').add(this.singleEvents).removeAttr('style');
                this.eventsWrapper.children('.grid-line').remove();
                this.element.hasClass('modal-is-open') && this.checkEventModal();
            } else if( mq == 'desktop' && this.element.hasClass('modal-is-open')){
                //on a mobile version with modal open - need to resize/move modal window
                this.checkEventModal('desktop');
                this.element.removeClass('loading');
            } else {
                this.placeEvents();
                this.element.removeClass('loading');
            }
        };

        SchedulePlan.prototype.initEvents = function() {
            var self = this;

            this.singleEvents.each(function() {
                var size = self.singleEvents.length > 2 ? '0.7em' : '1em';
                //create the .event-date element for each event
                var durationLabel = '<span class="event-date" style="overflow: hidden;font-size:' + size +'">'+$(this).data('start')+' - '+$(this).data('end')+'</span>';
                $(this).children('a').prepend($(durationLabel));

                //detect click on the event and open the modal
                $(this).on('click', 'a', function(event) {
                    event.preventDefault();
                    if( !self.animating ) self.openModal($(this));
                    $('#calendarPicker').hide();
                });
            });

            //close modal window
            this.modal.on('click', '.close', function(event){
                event.preventDefault();
                if( !self.animating ) self.closeModal(self.eventsGroup.find('.selected-event'));
                $('#calendarPicker').show();
            });
            // Update schedule element form prevention. (AJAX)
            this.modal.find('.event-info').on('submit','#updateForm',function(event) {
                $.ajax({
                    method: $(this).attr('method'),
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    success: function (data) {
                        self.closeModal(self.eventsGroup.find('.selected-event'));
                        self.placeEvents();
                    },
                    error: function (errors) {
                        formErrors(errors,$(this));
                    }
                });
                event.preventDefault();
            });
            // Delete schedule element form prevention. (AJAX)
            this.modal.find('.event-info').on('submit','#deleteForm',function(event) {
                $.ajax({
                    method: $(this).attr('method'),
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    success: function (data) {
                        self.closeModal(self.eventsGroup.find('.selected-event'));
                        self.placeEvents();
                    },
                    error: function (errors) {
                        formErrors(errors,$(this));
                    }
                });
                event.preventDefault();
            });
            this.element.on('click', '.cover-layer', function(event){
                if( !self.animating && self.element.hasClass('modal-is-open') ) {
                    self.closeModal(self.eventsGroup.find('.selected-event'));
                    self.placeEvents();
                    $('#calendarPicker').show();
                }
            });
        };

        SchedulePlan.prototype.placeEvents = function() {
            /*
             *	Special Algorithm to place events without overlapping.
             */
            var self = this,
                timeslots = [],
                events = [], event,
                i = 0, j = 0, eventsLength = 0,
                mq = this.mq();

            // Step 1: Initialize timeslots.
            for (i=0; i<1440; i++) {
                timeslots[i] = [];
            }

            this.eventsGroup.each(function () {
                events = [];
                var singleevents = $(this).find('.single-event');
                if (singleevents.length > 0) {
                    singleevents.sort(function (a, b) { return - ( parseInt(a.dataset.id) - parseInt(b.dataset.id) ) });
                    i = 0;
                    singleevents.each(function () {
                        var start = getScheduleTimestamp($(this).attr('data-start')),
                            end = getScheduleTimestamp($(this).attr('data-end'));

                        events.push({ id: i, start: start, end: end});
                        ++i;
                    });

                    // From here, we have our list of events of the current day that we can work with.
                    eventsLength = events.length;
                    //events.sort(function (a, b) {return a.id - b.id;});
                    // Step 2: Arrange the events by timeslot.
                    for (i = 0; i < eventsLength; i++) {
                        event = events[i];

                        // Safety first.
                        if (event.start > event.end) {
                            var temp = event.start;
                            event.start = event.end;
                            event.end = temp;
                        }

                        for (j=event.start; j<event.end; j++) {
                            timeslots[j].push(event.id);
                        }
                    }

                    // Step 3: Get each event it's horizontal position,
                    //         and figure out the max number of conflicts it has.
                    var eventIsUndefined = false;
                    for (i=0; i<1440; i++) {
                        var next_hindex = 0;
                        var timeslotLength = timeslots[i].length;

                        // If there's at least one event in the timeslot,
                        // we know how many events we will have going across for that slot.
                        if (timeslotLength > 0) {

                            // Store the greatest concurrent event count (cevc) for each event.
                            for (j=0; j<timeslotLength; j++) {
                                event = events[timeslots[i][j]];
                                if (event === undefined){
                                    event = events[timeslots[i][j]-1];
                                    eventIsUndefined = true;
                                } else {
                                    eventIsUndefined = false;
                                }

                                if (event.cevc === undefined || !event.cevc || event.cevc < timeslotLength) {
                                    if (!eventIsUndefined) {
                                        event.cevc = timeslotLength;
                                    }

                                    // Now is also a good time to coordinate horizontal ordering.
                                    // If this is our first conflict, start at the current index.
                                    if (!event.hindex) {
                                        event.hindex = next_hindex;

                                        // We also want to boost the index,
                                        // so that whoever we conflict with doesn't get the same one.
                                        next_hindex++;
                                    }
                                }
                            }
                        }
                    }

                    // Step 4: Calculate event coordinates and dimensions,
                    // and generate DOM.
                    var colWidth = $(singleevents[0]).parent().width(),
                        previousCevc = undefined;
                    for (i=0;i<eventsLength;++i) {
                        event = events[i];

                        // Height and y-coordinate are already known.
                        var duration = event.end - event.start;
                        event.pxh = self.eventSlotHeight*duration/self.timelineUnitDuration;
                        event.pxy = self.eventSlotHeight*(event.start - self.timelineStart)/self.timelineUnitDuration;

                        // Width is based on calendar current day column width and the cevc.
                        previousCevc = event.cevc === eventsLength ? event.cevc : eventsLength;
                        event.pxw = colWidth / previousCevc; // event.cevc;


                        // Height uses the same calendar/cevc figure,
                        // multiplied by the horizontal index to prevent overlap.
                        event.pxx = event.hindex * event.pxw;

                        // Now, the easy part.
                        if (mq == 'desktop') {
                            singleevents[i].style.width = event.pxw + "px";
                            singleevents[i].style.height = event.pxh + "px";
                            singleevents[i].style.top = event.pxy + "px";
                            singleevents[i].style.left = event.pxx + "px";
                        } else {
                            $(singleevents[i]).css('width','');
                            $(singleevents[i]).css('left','');
                            $(singleevents[i]).css('top','');
                            $(singleevents[i]).css('height','');
                        }
                        /*else {
                            if (self.timelineStart.toString() === NaN.toString()) {
                                self.timelineStart = 0;
                                self.timelineUnitDuration = 30;
                            }
                            var eventTop = self.eventSlotHeight*(event.start - self.timelineStart)/self.timelineUnitDuration,
                                eventHeight = self.eventSlotHeight*duration/self.timelineUnitDuration;
                            singleevents[i].style.height = (eventHeight-1);
                            singleevents[i].style.top = (eventTop-1) + "px";
                        }*/
                    }
                }
            });
            this.element.removeClass('loading');
        };

        SchedulePlan.prototype.openModal = function(event) {
            var self = this;
            var mq = self.mq();
            this.animating = true;

            //update event name and time
            previousWidth = $(event).parent().width();
            $(event).parent().css('width','');
            this.modalHeader.find('.event-name').text(event.find('.event-name').text());
            this.modalHeader.find('.event-date').text(event.find('.event-date').text());
            this.modal.attr('data-event', event.parent().attr('data-event'));

            //update event content
            if (location.href.includes('/schedule/editing')) {
                $.ajax({
                    method: 'GET',
                    url: '/schedule/' + event.parent().attr('data-slug') + '/edit',
                    success: function (view) {
                        self.modalBody.find('.event-info').html(view);
                    }
                });
            } else {
                self.modalBody.find('.event-info').html('<div style="color: black;font-size: 110%;">' + event.parent().attr('data-content') + '</div>');
            }
            self.element.addClass('content-loaded');
            self.element.addClass('modal-is-open');

            /*self.modalBody.find('.event-info').html('<div style="color: black;font-size: 110%;">' + event.parent().attr('data-content') + '</div>');
            self.element.addClass('content-loaded');
            self.element.addClass('modal-is-open');*/

            setTimeout(function(){
                //fixes a flash when an event is selected - desktop version only
                event.parent('li').addClass('selected-event');
            }, 10);

            if( mq == 'mobile' ) {
                self.modal.one(transitionEnd, function(){
                    self.modal.off(transitionEnd);
                    self.animating = false;
                });
                self.modal.css('z-index',99999);
            } else {
                var eventTop = event.offset().top - $(window).scrollTop(),
                    eventLeft = event.offset().left,
                    eventHeight = event.innerHeight(),
                    eventWidth = event.innerWidth();

                var windowWidth = $(window).width(),
                    windowHeight = $(window).height();

                var modalWidth = ( windowWidth*.8 > self.modalMaxWidth ) ? self.modalMaxWidth : windowWidth*.8,
                    modalHeight = ( windowHeight*.8 > self.modalMaxHeight ) ? self.modalMaxHeight : windowHeight*.8;

                var modalTranslateX = parseInt((windowWidth - modalWidth)/2 - eventLeft),
                    modalTranslateY = parseInt((windowHeight - modalHeight)/2 - eventTop);

                var HeaderBgScaleY = modalHeight/eventHeight,
                    BodyBgScaleX = (modalWidth - eventWidth);

                //change modal height/width and translate it
                self.modal.css({
                    top: eventTop+'px',
                    left: eventLeft+'px',
                    height: modalHeight+'px',
                    width: modalWidth+'px',
                });
                self.modal.css('z-index',99999);
                transformElement(self.modal, 'translateY('+modalTranslateY+'px) translateX('+modalTranslateX+'px)');

                //set modalHeader width
                self.modalHeader.css({
                    width: eventWidth+'px',
                });
                //set modalBody left margin
                self.modalBody.css({
                    marginLeft: eventWidth+'px',
                });

                //change modalBodyBg height/width ans scale it
                self.modalBodyBg.css({
                    height: eventHeight+'px',
                    width: '1px',
                });
                transformElement(self.modalBodyBg, 'scaleY('+HeaderBgScaleY+') scaleX('+BodyBgScaleX+')');

                //change modal modalHeaderBg height/width and scale it
                self.modalHeaderBg.css({
                    height: eventHeight+'px',
                    width: eventWidth+'px',
                });
                transformElement(self.modalHeaderBg, 'scaleY('+HeaderBgScaleY+')');

                self.modalHeaderBg.one(transitionEnd, function(){
                    //wait for the  end of the modalHeaderBg transformation and show the modal content
                    self.modalHeaderBg.off(transitionEnd);
                    self.animating = false;
                    self.element.addClass('animation-completed');
                });
            }

            //if browser do not support transitions -> no need to wait for the end of it
            if( !transitionsSupported ) self.modal.add(self.modalHeaderBg).trigger(transitionEnd);
        };

        SchedulePlan.prototype.closeModal = function(event) {
            var self = this;
            var mq = self.mq();

            this.animating = true;

            event.animate({width: previousWidth},700);
            if( mq == 'mobile' ) {
                this.element.removeClass('modal-is-open');
                this.modal.one(transitionEnd, function(){
                    self.modal.off(transitionEnd);
                    self.animating = false;
                    self.element.removeClass('content-loaded');
                    event.removeClass('selected-event');
                });
            } else {
                var eventTop = event.offset().top - $(window).scrollTop(),
                    eventLeft = event.offset().left,
                    eventHeight = event.innerHeight(),
                    eventWidth = event.innerWidth();

                var modalTop = Number(self.modal.css('top').replace('px', '')),
                    modalLeft = Number(self.modal.css('left').replace('px', ''));

                var modalTranslateX = eventLeft - modalLeft,
                    modalTranslateY = eventTop - modalTop;

                self.element.removeClass('animation-completed modal-is-open');

                //change modal width/height and translate it
                this.modal.css({
                    width: eventWidth+'px',
                    height: eventHeight+'px'
                });
                transformElement(self.modal, 'translateX('+modalTranslateX+'px) translateY('+modalTranslateY+'px)');

                //scale down modalBodyBg element
                transformElement(self.modalBodyBg, 'scaleX(0) scaleY(1)');
                //scale down modalHeaderBg element
                transformElement(self.modalHeaderBg, 'scaleY(1)');

                this.modalHeaderBg.one(transitionEnd, function(){
                    //wait for the  end of the modalHeaderBg transformation and reset modal style
                    self.modalHeaderBg.off(transitionEnd);
                    self.modal.addClass('no-transition');
                    setTimeout(function(){
                        self.modal.add(self.modalHeader).add(self.modalBody).add(self.modalHeaderBg).add(self.modalBodyBg).attr('style', '');
                    }, 10);
                    setTimeout(function(){
                        self.modal.removeClass('no-transition');
                    }, 20);

                    self.animating = false;
                    self.element.removeClass('content-loaded');
                    event.removeClass('selected-event');
                });
            }

            //browser do not support transitions -> no need to wait for the end of it
            if( !transitionsSupported ) self.modal.add(self.modalHeaderBg).trigger(transitionEnd);
        };

        SchedulePlan.prototype.mq = function(){
            //get MQ value ('desktop' or 'mobile')
            var self = this;
            return window.getComputedStyle(this.element.get(0), '::before').getPropertyValue('content').replace(/["']/g, '');
        };

        SchedulePlan.prototype.checkEventModal = function(device) {
            this.animating = true;
            var self = this;
            var mq = this.mq();

            if( mq == 'mobile' ) {
                //reset modal style on mobile
                $('.cover-layer')[0].style.zIndex = 88888;
                self.modal.add(self.modalHeader).add(self.modalHeaderBg).add(self.modalBody).add(self.modalBodyBg).attr('style', '');
                self.modal.removeClass('no-transition');
                self.animating = false;
                self.modal.css('z-index',99999);
            } else if( mq == 'desktop' && self.element.hasClass('modal-is-open') ) {
                $('.cover-layer')[0].style.zIndex = 88888;
                self.modal.addClass('no-transition');
                self.element.addClass('animation-completed');
                var event = self.eventsGroup.find('.selected-event');

                var eventTop = event.offset().top - $(window).scrollTop(),
                    eventLeft = event.offset().left,
                    eventHeight = event.innerHeight(),
                    eventWidth = event.innerWidth();

                var windowWidth = $(window).width(),
                    windowHeight = $(window).height();

                var modalWidth = ( windowWidth*.8 > self.modalMaxWidth ) ? self.modalMaxWidth : windowWidth*.8,
                    modalHeight = ( windowHeight*.8 > self.modalMaxHeight ) ? self.modalMaxHeight : windowHeight*.8;

                var HeaderBgScaleY = modalHeight/eventHeight,
                    BodyBgScaleX = (modalWidth - eventWidth);

                setTimeout(function(){
                    self.modal.css({
                        width: modalWidth+'px',
                        height: modalHeight+'px',
                        top: (windowHeight/2 - modalHeight/2)+'px',
                        left: (windowWidth/2 - modalWidth/2)+'px',
                        zIndex: 99999
                    });
                    transformElement(self.modal, 'translateY(0) translateX(0)');
                    //change modal modalBodyBg height/width
                    self.modalBodyBg.css({
                        height: modalHeight+'px',
                        width: '1px',
                    });
                    transformElement(self.modalBodyBg, 'scaleX('+BodyBgScaleX+')');
                    //set modalHeader width
                    self.modalHeader.css({
                        width: eventWidth+'px',
                    });
                    //set modalBody left margin
                    self.modalBody.css({
                        marginLeft: eventWidth+'px',
                    });
                    //change modal modalHeaderBg height/width and scale it
                    self.modalHeaderBg.css({
                        height: eventHeight+'px',
                        width: eventWidth+'px',
                    });
                    transformElement(self.modalHeaderBg, 'scaleY('+HeaderBgScaleY+')');
                }, 10);

                setTimeout(function(){
                    self.modal.removeClass('no-transition');
                    self.animating = false;
                }, 20);
            }
        };

        function load() {
            var schedules = $('.cd-schedule');
            var objSchedulesPlan = [],
                windowResize = false;

            if( schedules.length > 0 ) {
                schedules.each(function (e) {
                    //create SchedulePlan objects
                    objSchedulesPlan.push(new SchedulePlan($(this)));
                });
                if ($('.single-event').length > 0) {
                    var top = $($(".single-event")[Math.floor(Math.random() * $(".single-event").length)]).offset().top;
                    $('#loading').modal('hide');
                    $('html, body').animate({
                        scrollTop: top - 400
                    }, 500);
                } else {
                    $('html, body').animate({
                        scrollTop: 0
                    }, 500);
                }
            }

            $(window).on('resize', function(){
                if( !windowResize ) {
                    windowResize = true;
                    (!window.requestAnimationFrame) ? setTimeout(checkResize) : window.requestAnimationFrame(checkResize);
                }
            });

            $(window).keyup(function(event) {
                if (event.keyCode == 27) {
                    objSchedulesPlan.forEach(function(element){
                        element.closeModal(element.eventsGroup.find('.selected-event'));
                    });
                }
            });

            function checkResize(){
                objSchedulesPlan.forEach(function(element){
                    element.scheduleReset();
                });
                windowResize = false;
            }
        }

        function getScheduleTimestamp(time) {
            //accepts hh:mm format - convert hh:mm to timestamp
            time = time.replace(/ /g,'');
            var timeArray = time.split(':');
            var timeStamp = parseInt(timeArray[0])*60 + parseInt(timeArray[1]);
            return timeStamp;
        }

        function transformElement(element, value) {
            element.css({
                '-moz-transform': value,
                '-webkit-transform': value,
                '-ms-transform': value,
                '-o-transform': value,
                'transform': value
            });
        }

        return { load: load};
    }

    var place = new PlacerHoraire();
    var calendarVue = new Vue({
        el: "#calendar",
        data: {
            days: ["Dimanche","Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi","Samedi"],
            colors: ['event-1','event-2','event-3','event-4'],
            weekevents: []
        },
        computed: {},
        methods: {
            thisdayhaveanevent: function (day) {
                return this.weekevents[day] !== 'undefined';
            },
            getevent: function (day) {
                return this.weekevents[day];
            },
            sort: function(data) {
                var newEvents = [],
                    self = this;
                for (var day in data.weekevents) {
                    data.weekevents[day].forEach(function (event) {
                        event.color = self.colors[Math.floor(Math.random() * self.colors.length)];
                    });
                }
                for (var day in data.weekevents) {
                    data.weekevents[day].forEach(function (event) {
                        var dateEnd = event.end.split(" ");
                        if (dateEnd.length > 1) {
                            // Get ending time from event ending date
                            var end = dateEnd[1];
                            // Create new event with same properties but starting the next day
                            var newEvent = JSON.parse(JSON.stringify(event));
                            // Set event to end at midnignt to allow new event to start the next day
                            event.end = '23:59';
                            // Set new event begin and end attributes
                            newEvent.begin = '00:00';
                            newEvent.end = end;

                            var curr = new Date(dateEnd[0]),
                                first = curr.getDate() - curr.getDay(), // First day is the day of the month - the day of the week
                                last = first + 6,                       // last day is the first day + 6
                                lastDayOfTheWeek = new Date(curr.setDate(last)).getDay();

                            // Get date from event ending date
                            var eventEndingDate = new Date(dateEnd[0]);
                            var eventEndingDay = eventEndingDate.getDay() + 1;
                            for (var newDay = self.getDateFromDayInCurrentCalendarDate(day).getDay() + 1; newDay <= lastDayOfTheWeek; ++newDay) {
                                if (self.getDateFromDayInCurrentCalendarDate(self.getStringDayFromNumberDay(newDay)) < eventEndingDate) {
                                    newEvent.end = '23:59';
                                    var nextDay = self.getStringDayFromNumberDay(newDay);
                                    if (newEvents[nextDay] === undefined) newEvents[nextDay] = [];
                                    newEvents[nextDay].push(newEvent);
                                } else if (newDay === eventEndingDay) {
                                    var LastDayEvent = JSON.parse(JSON.stringify(newEvent));
                                    LastDayEvent.end = end;
                                    var nextDay = self.getStringDayFromNumberDay(newDay);
                                    if (newEvents[nextDay] === undefined) newEvents[nextDay] = [];
                                    newEvents[nextDay].push(LastDayEvent);
                                }
                            }
                        }
                    });
                }

                // Put new events in main array of data (weekevents).
                for (var day in newEvents) {
                    newEvents[day].forEach(function (event) {
                        data.weekevents[day].push(event);
                    });
                }
                self.weekevents = data.weekevents;
            },
            getScheduleTimestamp: function(time) {
                //accepts hh:mm format - convert hh:mm to timestamp
                time = time.replace(/ /g,'');
                var timeArray = time.split(':');
                var timeStamp = parseInt(timeArray[0])*60 + parseInt(timeArray[1]);
                return timeStamp;
            },
            getNextDayFromStringDay: function(day) {
                switch (day) {
                    case 'Lundi': return 'Mardi';     break;
                    case 'Mardi': return 'Mercredi';  break;
                    case 'Mercredi': return 'Jeudi';  break;
                    case 'Jeudi': return 'Vendredi';  break;
                    case 'Vendredi': return 'Samedi'; break;
                    case 'Samedi': return 'Dimanche'; break;
                    case 'Dimanche': return 'Lundi';  break;
                }
            },
            getStringDayFromNumberDay: function(day) {
                switch (day) {
                    case 0: return 'Dimanche';     break;
                    case 1: return 'Lundi';        break;
                    case 2: return 'Mardi';        break;
                    case 3: return 'Mercredi';     break;
                    case 4: return 'Jeudi';        break;
                    case 5: return 'Vendredi';     break;
                    case 6: return 'Samedi';       break;
                }
            },
            getDateFromDayInCurrentCalendarDate: function(day) {
                var date = new Date(myCalendar.getDate(false));
                switch (day) {
                    case 'Dimanche': return new Date(date.setDate(date.getDate() - date.getDay()/* + 0*/)); break;
                    case 'Lundi':    return new Date(date.setDate(date.getDate() - date.getDay() + 1));     break;
                    case 'Mardi':    return new Date(date.setDate(date.getDate() - date.getDay() + 2));     break;
                    case 'Mercredi': return new Date(date.setDate(date.getDate() - date.getDay() + 3));     break;
                    case 'Jeudi':    return new Date(date.setDate(date.getDate() - date.getDay() + 4));     break;
                    case 'Vendredi': return new Date(date.setDate(date.getDate() - date.getDay() + 5));     break;
                    case 'Samedi':   return new Date(date.setDate(date.getDate() - date.getDay() + 6));     break;
                }
            },
            loadFromDate: function(date) {
                var self = this;
                self.weekevents = [];

                var modal = $('#loading');
                modal.modal();

                $.ajax({
                    method: 'GET',
                    url: '/schedule/week/' + date,
                    success: function (data) {
                        // Sort data to place events that last for 2 days or more
                        let canBeDone = false;
                        for (var k in data.weekevents) {
                            if (data.weekevents[k].length > 0) {
                                canBeDone = true;
                                break;
                            }
                        }
                        if (canBeDone)
                            self.sort(data);
                        modal.modal('hide');
                    }
                });
            }
        },
        created: function () {},
        updated: function () {
            place.load();
        },
        mounted: function() {
            this.loadFromDate(new Date().format('yyyy-mm-dd'));
        },
        beforeMount: function() {}
    });

	// add once, make sure dhtmlxcalendar.js is loaded
    dhtmlXCalendarObject.prototype.langData["fr"] = {
        // date format
        dateformat: "%Y.%m.%d",
        // full names of months
        monthesFNames: [
            "Janvier","Février","Mars","Avril","Mai","Juin","Juillet",
            "Août","Septembre","Octobre","Novembre","Décembre"
        ],
        // short names of months
        monthesSNames: [
            "Janv","Févr","Mar","Avr","Mai","Juin",
            "Juill","Août","Sept","Oct","Nov","Déc"
        ],
        // full names of days
        daysFNames: [
            "Dimanche","Lundi","Mardi","Mercredi",
            "Jeudi","Vendredi","Samedi"
        ],
        // short names of days
        daysSNames: [
            "Dim","Lun","Mar","Mer",
            "Jeu","Ven","Sam"
        ],
        // starting day of a week. Number from 1(Monday) to 7(Sunday)
        weekstart: 1,
        // the title of the week number column
        weekname: "s"
    };
	// init calendar
    var myCalendar = new dhtmlXCalendarObject('calendarPicker');
    myCalendar.loadUserLanguage('fr');
    myCalendar.setDate(new Date());
    myCalendar.hideTime();

	// Set onTimeChange event to reload calendar with new data from server
	// with the selected date
    myCalendar.attachEvent('onBeforeChange',function(date) {
        var dateToSend = date.format('yyyy-mm-dd');
        calendarVue.loadFromDate(dateToSend);
        return true;
    });

	// Show calendar
    myCalendar.show();

    $('#firstSection').height($('#secondSection').height());
    var tableMarginTop = Math.round( ($('#firstSection').height() - $('#firstTable').height()) / 2 );
    $('#firstTable').css('margin-top', tableMarginTop);
});