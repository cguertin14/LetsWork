$(document).ready(function () {
    $(".phone-number").mask("(999) 999-9999");

    $(".clickable-section").click(function() {
        window.location = $(this).data("href");
    });
});