<script>
    $(".dropdown").click(function () {
        if ($(".dropdown").find("ul").hasClass("in")) {
            $(".dropdown").find("ul").removeClass("in");
        }
        else {
            $(".dropdown").find("ul").addClass("in");
        }
    });
</script>