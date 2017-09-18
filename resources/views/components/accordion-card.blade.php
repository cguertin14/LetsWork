<div class="card">
    <div class="card-header" role="tab" id="heading{{$cardname}}">
        <h5 class="mb-0">
            <a data-toggle="collapse" data-parent="#{{$idaccordion}}" href="#collapse{{$cardname}}" aria-expanded="false" aria-controls="collapse{{$cardname}}">
                {{$cardlink}}
            </a>
        </h5>
    </div>

    <div id="collapse{{$cardname}}" class="collapse" role="tabpanel" aria-labelledby="heading{{$cardname}}">
        <div class="card-body">
            {{$cardbody}}
        </div>
    </div>
</div>