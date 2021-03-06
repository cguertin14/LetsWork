<div id="calendar" class="cd-schedule loading" v-cloak>
    <div class="timeline">
        <ul id="hour-container"></ul>
    </div> <!-- .timeline -->

    <div class="events">
        <ul class="schedule-ul">
            <li class="events-group" v-for="day in days">
                <div class="top-info"><span>@{{ day }}</span></div>
                <ul>
                    <li class="single-event" :data-id="event.id" :data-slug="event.slug" :data-start="event.begin" :data-end="event.end" :data-content="event.description" :data-event="event.color" v-if="thisdayhaveanevent(day)" v-for="event in getevent(day)">
                        <a href="#0">
                            <em class="event-name" style="overflow: hidden;display: block">@{{ event.name }}</em>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>

    <div class="event-modal">
        <header class="header">
            <div class="content">
                <span class="event-date"></span>
                <h3 class="event-name"></h3>
            </div>

            <div class="header-bg"></div>
        </header>

        <div class="body">
            <div class="event-info"></div>
            <div class="body-bg"></div>
        </div>

        <a href="#0" class="close">Close</a>
    </div>

    <div class="cover-layer"></div>
</div> <!-- .cd-schedule -->