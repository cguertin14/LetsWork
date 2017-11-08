@component('components.modal')
    @slot('title')
        Créer un horaire
    @endslot
    @slot('body')
        <!-- Formulaire de création d'événement -->
        {!! Form::open(['method' => 'POST','action' => 'ScheduleController@store','class' => 'form-horizontal','id' => 'createForm']) !!}
        <div class="row">
            <div class="col-md-12" id="container">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('name', 'Nom de l\'horaire', ['class' => 'section-title']); !!}
                        {!! Form::text('name',null,['class' => 'form-control','placeholder' => 'Nom de l\'horaire','required']); !!}
                    </div>
                </div>
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
                <div class="col-md-6" id="errorsParent" style="display: none;">
                    <div class="form-group" id="errors">
                    </div>
                </div>
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
            function setNewEvent() {
                if (!$('#new-event')) {
                    var content = $.parseHTML('<td class="col-xs-2">\n' +
                        '                        <img style="cursor: pointer;display: inline-block" id="new-event" src="{{asset('image/purple_plus.png')}}" alt="" height="70px" width="70px">\n' +
                        '                    </td>\n' +
                        '                    <td class="col-xs-10">\n' +
                        '                        <h1 class="page-title" style="font-size: 2em">Ajouter un événement</h1>\n' +
                        '                    </td>');
                    $(content).appendTo('#add-event-section').show('slow');
                }
            }
        </script>
    @endslot
@endcomponent