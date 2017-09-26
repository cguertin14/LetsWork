$(document).ready(function () {
    $(".phone-number").mask("(999) 999-9999");
});

$(".confirm_action").onkeyup(function () {
    if ($(this).val() == '') {
        $('.confirm_action').prop('disabled', true);
    } else {
        $('.confirm_action').prop('disabled', false);
    }
});