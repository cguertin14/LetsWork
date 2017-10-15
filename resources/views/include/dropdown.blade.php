@if (\Illuminate\Support\Facades\Auth::check())
<script>
    function dropdown(container,title,height,image) {
        $(title).click(function () {
            if ($(container).height() === 0) {
                $(container).height(height);
                $(image).css({'transform': 'rotate(-180deg)'});
            } else {
                $(container).height(0);
                $(image).css({'transform': 'rotate(0deg)'});
            }
        });
    }

    dropdown("#dropdown1","#dropdown1Title",100,"#img1");
    dropdown("#dropdown2","#dropdown2Title",50 * {{count(\Illuminate\Support\Facades\Auth::user()->companies)}},"#img2");
    dropdown("#dropdown3","#dropdown3Title",250,"#img3");
    dropdown("#dropdown4","#dropdown4Title",100,"#img4");
    dropdown("#dropdown5","#dropdown5Title",100,"#img5");
    dropdown("#dropdown6","#dropdown6Title",100,"#img6");

</script>
@endif
