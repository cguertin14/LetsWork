$(document).ready(function ($) {
    $(".phone-number").mask("(999)-999-9999");

    $(".confirm_action").click(function () {
        return show_confirmation_modal($(".confirm_action"));
    });

    $(".clickable-section").click(function() {
        window.location = $(this).data("href");
    });

    Array.prototype.chunk = function ( n ) {
        if ( !this.length ) {
            return [];
        }
        return [ this.slice( 0, n ) ].concat( this.slice(n).chunk(n) );
    };
});

function setUserProfilePic(route) {
    $.get({
        url: route,
        success: function(result) {
            $("#image").attr('src',"data:image/png;base64," + result.photo.source);
        }
    });
}

function formErrors(errors,modal) {
    var formErrors = JSON.parse(errors.responseText.replace(/\\'/g, "'"));
    var errorsContainer = $('<div class="alert alert-danger"><ul id="errors" style="list-style: inherit !important;"></ul></div>');
    $.each(formErrors,function (key,error) {
        errorsContainer.find('#errors').append('<li>'+error+'</li>')
    });
    modal.find('#errors').append(errorsContainer).parent().show('slow');
}

function getUserCV() {
    $.ajax({
        type: 'GET',
        url: '/cv'
    }).done(function (data) {
        if (data !== null)
            PDFObject.embed("data:application/pdf;base64," + data.cv, "#cv_file");
    });
}

function sendCV() {
    $("#create_cv").submit(function(e) {
        $.ajax({
            type: 'POST',
            url: '/cv/store',
            data: new FormData($("#create_cv")[0]),
            processData: false,
            contentType: false,
            success: function(data) {
                if (data !== null)
                    PDFObject.embed("data:application/pdf;base64," + data.cv, "#cv_file");
            }
        });
        e.preventDefault();
    });
}

function sendLetter() {
    $("#create_letter").submit(function(e) {
        $.ajax({
            type: 'POST',
            url: '/joboffer/lettre',
            data: new FormData($("#create_letter")[0]),
            processData: false,
            contentType: false,
            success: function(data) {
                if (data !== null)
                    PDFObject.embed("data:application/pdf;base64," + data, "#letter_file");
            }
        });
        e.preventDefault();
    });
}

function CheckFile() {
    var file = document.getElementById("uploader");
    var len = file.value.length;
    var ext = file.value;
    if (ext.substr(len - 3, len).toLowerCase() != "pdf") {
        alert("Ce n'est pas un fichier de format PDF! Sélectionnez un autre fichier...");
        return false;
    }
    return true;
}

function show_confirmation_modal(e) {
    if ($('#modal_confirmation'))
        $('#modal_confirmation').remove();
    $("body").append($("<div id='modal_confirmation' class=\"modal fade\"><div class=\"\modal-dialog\" role=\"document\"><div class=\"modal-content\"></div></div></div>"));
    $("div.modal-content").append($("<div class=\"modal-header\"><h5 class=\"modal-title\" style='display: inline-block'>Confirmation de votre action</h5>" +
        "<button id='exit_modal' type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">" +
        "<span aria-hidden=\"true\">&times;</span>" +
        "</button> </div>"));
    $("div.modal-content").append($("<div class=\"modal-body\">" +
        "<p>" + e.attr("c_m_text") + "</p>" +
        "</div>"));
    $("div.modal-content").append($(
        "<div class=\"modal-footer\">\n" +
        "<button id='validation_modal' type=\"button\" class=\"btn btn-success\">Oui</button>" +
        "<button id='annulation_modal' type=\"button\" class=\"btn btn-danger\" data-dismiss=\"modal\">Non</button>" +
        "</div>"));

    $("#validation_modal").click(function () {
        $("#modal_confirmation").remove();
        $(".modal-backdrop").remove();
        if(e.parent("form")) {
            e.parent("form")[0].submit();
        } else {
            location.href=e.attr("href");
        }
    });
    $("#annulation_modal").mouseup(function () {
        $("#modal_confirmation").remove();
        $(".modal-backdrop").remove();
    });
    $("#exit_modal").click(function () {
        $("#modal_confirmation").remove();
        $(".modal-backdrop").remove();
    });
    $("#modal_confirmation").modal();
    return false;
}