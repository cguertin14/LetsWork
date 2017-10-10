$(document).ready(function () {
    for (var i=0; i<=23;++i)
        $("#hour-container").append("<li><span>" + (i < 10 ? "0" + i : i) + ":00</span></li>" + "<li><span>" +
            (i < 10 ? "0" + i : i) + ":30</span></li>");

    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-48014931-1', 'codyhouse.co');
    ga('send', 'pageview');

    jQuery(document).ready(function($){
        $('.close-carbon-adv').on('click', function(event){
            event.preventDefault();
            $('#carbonads-container').hide();
        });
    });
});