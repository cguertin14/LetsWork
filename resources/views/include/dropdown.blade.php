@if (\Illuminate\Support\Facades\Auth::check())
<script>
    function dropdown(container,title,height,image) {
        $(title).click(function () {
            if ($(container).height() === 0) {
                $(container).height(height);
                $(image).css({'transform': 'rotate(-180deg)','transition-duration': '0.5s'});
            } else {
                $(container).height(0);
                $(image).css({'transform': 'rotate(0deg)','transition-duration': '0.5s'});
            }
        });
    }

    dropdown("#dropdown1","#dropdown1Title",100,"#img1");
    @php
        $height = 0;
        $jobs = \Illuminate\Support\Facades\Auth::user()->employees()->get()->map(function (\App\Employee $employee) { return $employee->companies()->get()->unique(); })->first();
        if ($jobs != null) $jobs = $jobs->merge(\Illuminate\Support\Facades\Auth::user()->companies()->get())->unique();
    @endphp
    @if ($jobs != null && $jobs->count() > 1)
        @foreach($jobs as $company)
            @if ($company->slug !== \App\Tools\Helper::CCompany()->slug)
                @php($height+=50)
            @endif
        @endforeach
    @endif
    dropdown("#dropdown2","#dropdown2Title",{{$height}},"#img2");
    dropdown("#dropdown3","#dropdown3Title",100,"#img3");
    dropdown("#dropdown4","#dropdown4Title",100,"#img4");
    dropdown("#dropdown5","#dropdown5Title",50,"#img5");
    dropdown("#dropdown6","#dropdown6Title",@if(\Illuminate\Support\Facades\Auth::user()->isOwner()) 100 @else 50 @endif,"#img6");
    dropdown("#dropdown7","#dropdown7Title",100,"#img7");
    @if ($jobs != null)
        dropdown("#dropdown8","#dropdown8Title",100,"#img8");
        @if (\App\Tools\Helper::CCompany() != null)
            dropdown("#dropdownMyJob","#dropdownMyJobTitle",@if (\App\Tools\Helper::CIsHighRanked()) 350 @else 150 @endif,"#imgMyJob")
        @endif
    @endif

</script>
@endif
