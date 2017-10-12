@component('components.modal')
    @slot('title')
        Créer un événement
    @endslot
    @slot('body')
        <!-- Formulaire de création d'événement -->
        {!! Form::open(['method' => 'POST','action' => 'ScheduleController@store','class' => 'form-horizontal','id' => 'createForm']) !!}
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('begin', 'Date de début', ['class' => 'section-title']); !!}
                        <div class='input-group date' id='begin'>
                            {!! Form::text('begin', null, ['class' => 'form-control','required']); !!}
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('end', 'Date de fin', ['class' => 'section-title']); !!}
                        <div class='input-group date' id='end'>
                            {!! Form::text('end', null, ['class' => 'form-control','required']); !!}
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('user_id', 'Assigner la tâche à', ['class' => 'section-title']); !!}
                        {!! Form::select('user_id',$employees,null,['class' => 'form-control','required']); !!}
                    </div>
                </div>
                {{--<div class="col-md-6">
                    <div class="form-group">
                        @include('include.errors')
                    </div>
                </div>--}}
            </div>
        </div>
        {!! Form::submit('Submit',['class' => 'btn purblebtn','style' => 'display:none','id' => 'submit']) !!}
        {!! Form::close() !!}
    @endslot
    @slot('submitbtn')
        <!-- Bouton submit pour le formulaire (implémenter du JS pour preventDefault() -->
        <button type="button" class="btn purplebtn createSubmit">Créer</button>
    @endslot
    @slot('events')
        <script>
            $(function () {
                $('#begin').datetimepicker({
                    defaultDate: new Date(),
                    format: 'YYYY-DD-MM HH:mm:ss',
                    locale: 'fr-ca'
                });
                $('#end').datetimepicker({
                    defaultDate: new Date(),
                    format: 'YYYY-DD-MM HH:mm:ss',
                    locale: 'fr-ca'
                });
            });
        </script>
    @endslot
@endcomponent