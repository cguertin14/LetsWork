@component('components.modal')
    @slot('title')
        Période de travail du {{\Carbon\Carbon::parse($punch->datebegin)->toDateString()}}
    @endslot
    @slot('body')
        <div class="row">
            <div class="form-group col-md-6">
                {!! Form::label('dateend', 'Début', ['class' => 'section-title']); !!}
                <p style="color: white;">{{\Carbon\Carbon::parse($punch->datebegin)->toDateTimeString()}}</p>
            </div>
            <div class="form-group col-md-6">
                {!! Form::label('dateend', 'Fin', ['class' => 'section-title']); !!}
                <p style="color: white;">{{\Carbon\Carbon::parse($punch->dateend)->toDateTimeString()}}</p>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('task', 'Description de la/les tâche(s) effectuée(s)', ['class' => 'section-title']); !!}
            <br>
            {!! Form::textarea('task',$punch->task,['class' => 'form-control','disabled','rows' => 3]); !!}
        </div>
    @endslot
    @slot('submitbtn')
    @endslot
    @slot('events')
    @endslot
@endcomponent