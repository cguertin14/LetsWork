@component('components.modal')
    @slot('title')
        Créer un événement
    @endslot
    @slot('body')
        <!-- Formulaire de création d'événement -->
        {!! Form::open(['method' => 'POST','action' => 'ScheduleController@storeelement','class' => 'form-horizontal','id' => 'createForm']) !!}
        <div class="row">
            <div class="col-md-12" id="container">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('schedule_id', 'Horaire', ['class' => 'section-title']); !!}
                        {!! Form::select('schedule_id',$schedules,null,['class' => 'form-control','required']); !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('name', 'Nom', ['class' => 'section-title']); !!}
                        {!! Form::text('name',null,['class' => 'form-control','placeholder' => 'Nom','required']); !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('description', 'Description', ['class' => 'section-title']); !!}
                        {!! Form::textarea('description',null,['class' => 'form-control','placeholder' => 'Description','required','rows' => 3,'style' => 'resize:none']); !!}
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
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('specialroles[]', 'Types d\'employés voulus', ['class' => 'section-title']); !!}
                        {!! Form::select('specialroles[]',$specialRoles,null,['class' => 'form-control selectpicker','required','multiple' => 'multiple','data-actions-box' => 'true','id' => 'special_role']); !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <section style="display: inline-flex">
                            <!-- .slideTwo -->
                            <div class="slideTwo">
                                <input type="checkbox" value="None" id="specific_user_checkbox" name="check"/>
                                <label for="specific_user_checkbox"></label>
                            </div>
                            <!-- end .slideTwo -->
                        </section>
                        <label class="text-center section-title" style="margin-left: 0.5em">Employés spécifiques</label>
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
                $('#specific_user_checkbox').change(function () {
                    var data = $('#special_role option:selected').map(function() {
                        return this.value
                    }).get();
                    getEmployeesByRole(data,6);
                });
                $('.selectpicker').selectpicker({});
                $('#special_role').change(function () {
                    if ($('#specific_user')) {
                        var data = $('#special_role option:selected').map(function() {
                            return this.value
                        }).get();
                        getEmployeesByRole(data,6);
                    } else {
                        // DO NOTHING.
                    }
                });
            });
        </script>
    @endslot
@endcomponent