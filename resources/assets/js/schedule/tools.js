jQuery(document).ready(function ($) {
    // Modal de création d'événement
    $('.custom-table').on('click','#new-event',function (event) {
        event.preventDefault();
        $.ajax({
            method: 'GET',
            url: '/schedule/scheduleelement',
            success: function (view) {
                var createEventModal = $('#createEventModal');
                createEventModal.empty();
                createEventModal.html(view);
                createEventModal.modal();
                createEventModal.on('hidden.bs.modal', function () { $(this).empty(); });
                createEventModal.find('.createSubmit').click(function (event) {
                    event.preventDefault();
                    createEventModal.find('#createForm').submit(function (event) {
                        $.ajax({
                            type: createEventModal.find('#createForm').attr('method'),
                            url: createEventModal.find('#createForm').attr('action'),
                            data: createEventModal.find('#createForm').serialize(),
                            success: function(data) {
                                ///////////// PLACE DATA IN CALENDAR WITH VUE.JS.
                                createEventModal.modal('hide');
                                calendarVue.loadFromDate(myCalendar.getDate().format('yyyy-mm-dd'));
                            }
                        });
                        event.preventDefault();
                        return false;
                    });
                    createEventModal.find('#submit').trigger('click');
                });
            }
        });
    });
    // Modal de création d'horaire
    $('#new-schedule').click(function (event) {
        event.preventDefault();
        $.ajax({
            method: 'GET',
            url: '/schedule/create',
            success: function (view) {
                var createScheduleModal = $('#createScheduleModal');
                createScheduleModal.empty();
                createScheduleModal.html(view);
                createScheduleModal.modal();
                createScheduleModal.on('hidden.bs.modal', function () {
                    $(this).empty();
                });
                createScheduleModal.find('.createSubmit').click(function (event) {
                    event.preventDefault();
                    createScheduleModal.find('#createForm').submit(function (event) {
                        $.ajax({
                            method: createScheduleModal.find('#createForm').attr('method'),
                            url: createScheduleModal.find('#createForm').attr('action'),
                            data: createScheduleModal.find('#createForm').serialize(),
                            success: function(data) {
                                createScheduleModal.modal('hide');
                                setNewEvent();
                            },
                            error: function (errors) {
                                formErrors(errors,createScheduleModal);
                            }
                        });
                        event.preventDefault();
                        return false;
                    });
                    createScheduleModal.find('#submit').trigger('click');
                });
            }
        });
    });
});

function getEmployeesByRole(roles,size) {
    const self = document.getElementById('specific_user_checkbox');
    if (self.checked) {
        // Get employés selon leur role
        var specificuser = null;
        if ($('#container').find('#specific_user').length === 0) {
            specificuser = $.parseHTML("<div id=\"specific_user\" style='display: none;' class=\"col-md-"+size+"\">" +
                        "                    <div class=\"form-group\">" +
                        "                        <label id='user_id_label' for=\"users[]\" class=\"section-title\">Employés spécifiques voulus</label>" +
                        "                        <select class='form-control selectpicker' multiple='multiple' data-actions-box='true' required id=\"users\" name='users[]'></select>" +
                        "                    </div>" +
                        "               </div>");

            if (size === 12)
                $(specificuser).find('#user_id_label').attr('style','color:black!important');

        } else
            specificuser = $('#specific_user');
        $.ajax({
            method: 'GET',
            url: '/schedule/employees/' + roles,
            success: function (data) {
                if (data !== '') {
                    if (data.employees.length > 0) {
                        $.each(data, function() {
                            $.each(this, function(key, user) {
                                $(specificuser).find('#users').append('<option value="'+user.id+'">'+user.name+'</option>');
                            });
                        });
                        $(specificuser).find('#users').selectpicker({});
                        $(specificuser).appendTo('#container').show('slow');
                    } else {
                        alert('Il n\'y a pas d\'employé qui ont ce poste, veuillez réessayer');
                        self.checked = false;
                        // Remove view from container
                        if ($('#specific_user')) {
                            $('#specific_user').hide(500,function () {
                                $(this).remove()
                            });
                        }
                    }
                } else {
                    alert('Veuillez sélectionner au moins un type d\'employé');
                    self.checked = false;
                    // Remove view from container
                    if ($('#specific_user')) {
                        $('#specific_user').hide(500,function () {
                            $(this).remove()
                        });
                    }
                }
            }
        });
    } else {
        // Remove view from container
        if ($('#specific_user')) {
            $('#specific_user').hide(500,function () {
                $(this).remove()
            });
        }
    }
}