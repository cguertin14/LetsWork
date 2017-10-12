jQuery(document).ready(function ($) {
    // Modal de création d'événement
    $("#new-event").click(function (event) {
        event.preventDefault();
        $.ajax({
            method: 'GET',
            url: '/schedule/create',
            success: function (view) {
                var modal = $('#createEventModal');
                modal.html(view);
                modal.modal();
                modal.find('.createSubmit').click(function (event) {
                    event.preventDefault();
                    modal.find('#createForm').submit(function (event) {
                        $.ajax({
                            type: 'POST',
                            url: '/schedule',
                            data: modal.find('#createForm').serialize(),
                            success: function(data) {
                                ///////////// PLACE DATA IN CALENDAR WITH VUE.JS.
                                if (data !== null)
                                    console.log(data);

                                modal.modal('hide');
                            }//,
                            // error: function (errors) {
                            //     console.log(errors.responseText);
                            //     modal.find('#createForm')[0].reset();
                            // }
                        });
                        event.preventDefault();
                        return false;
                    });
                    modal.find('#submit').trigger('click');
                });
            }
        });
    });
});
