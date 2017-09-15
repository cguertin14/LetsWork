<div class="card">
    <div class="card-header" role="tab" id="heading{{$cardname}}">
        <h5 class="mb-0">
            <a data-toggle="collapse" href="#collapse{{$cardname}}" aria-expanded="true" aria-controls="collapse{{$cardname}}">
                {{$cardlink}}
            </a>
        </h5>
    </div>

    <div id="collapse{{$cardname}}" class="collapse show" role="tabpanel" aria-labelledby="heading{{$cardname}}" data-parent="#{{$idaccordion}}">
        <div class="card-body">
            {{$cardbody}}
        </div>
    </div>
</div>