@component('components.modal')
    @slot('title')
        Période de travail du {{\Carbon\Carbon::parse($punch->datebegin)->toDateString()}}
    @endslot
    @slot('body')
        <div class="row">
            <div class="form-group col-md-4">
                {!! Form::label('datebegin', 'Début', ['class' => 'section-title']); !!}
                <p style="color: white;">{{\Carbon\Carbon::parse($punch->datebegin)->toDateTimeString()}}</p>
            </div>
            <div class="form-group col-md-4">
                {!! Form::label('dateend', 'Fin', ['class' => 'section-title']); !!}
                <p style="color: white;">@if($punch->dateend) {{\Carbon\Carbon::parse($punch->dateend)->toDateTimeString()}} @else Période non-complétée @endif</p>
            </div>
            <div class="form-group col-md-4">
                {!! Form::label('duration', 'Durée', ['class' => 'section-title']); !!}
                <p style="color: white;">@if($punch->dateend) {{round(\Carbon\Carbon::parse($punch->dateend)->diffInMinutes(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$punch->datebegin)) / 60,2)}} heure(s) @else Période non-complétée @endif</p>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('task', 'Description de la/les tâche(s) effectuée(s)', ['class' => 'section-title']); !!}
            <br>
            {!! Form::textarea('task',$punch->task ? $punch->task : 'Aucune description de tâche(s).',['class' => 'form-control','disabled','rows' => 3]); !!}
        </div>
    @endslot
    @slot('submitbtn')
    @endslot
    @slot('events')
    @endslot
@endcomponent