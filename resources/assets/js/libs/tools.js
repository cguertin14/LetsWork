$(document).ready(function () {
    $(".phone-number").mask("(999) 999-9999");

    $(".confirm_action").click(function () {
        return show_confirmation_modal($(".confirm_action"));
    });

    $(".clickable-section").click(function() {
        window.location = $(this).data("href");
    });
});


function show_confirmation_modal(e) {
    $("body").append($("<div id='modal_confirmation' class=\"modal fade\"><div class=\"\modal-dialog\" role=\"document\"><div class=\"modal-content\"></div></div></div>"));
    $("div.modal-content").append($("<div class=\"modal-header\"><h5 class=\"modal-title\">Confirmation de votre action</h5>" +
        "<button id='exit_modal' type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">" +
        "<span aria-hidden=\"true\">&times;</span>" +
        "</button> </div>"));
    $("div.modal-content").append($("<div class=\"modal-body\">" +
        "<p>" + e.attr("c_m_text") + "</p>" +
        "</div>"));
    $("div.modal-content").append($(
        "<div class=\"modal-footer\">\n" +
        "<button id='validation_modal' type=\"button\" class=\"btn btn-primary\">Valider</button>" +
        "<button id='annulation_modal' type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Annuler</button>" +
        "</div>"));

    $("#validation_modal").click(function () {
        $("#modal_confirmation").remove();
        $(".modal-backdrop").remove();
        if(e.parent("form"))
        {
            e.parent("form")[0].submit();
        }
        else
        {
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