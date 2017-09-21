<script>
    function dropdown(name) {
        $(name).click(function () {
            if ($(name).find("ul").hasClass("in")) {
                $(name).find("ul").removeClass("in");
            }
            else {
                $(name).find("ul").addClass("in");
            }
        });
    }

    dropdown("#dropdown1");
    dropdown("#dropdown2");
    dropdown("#dropdown3");

</script>