<div class="col-md-12">
    <!-- Formulaire de création d'événement -->
    {!! Form::model($scheduleelement,['method' => 'PATCH','action' => ['ScheduleController@update',$scheduleelement->slug],'class' => 'form-horizontal','id' => 'updateForm']) !!}
    <div class="row">
        <div class="col-md-12" id="container">
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::label('schedule_id', 'Horaire', ['class' => 'section-title','style' => 'color:black']); !!}
                    {!! Form::select('schedule_id',$schedules,null,['class' => 'form-control','required']); !!}
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::label('name', 'Nom', ['class' => 'section-title','style' => 'color:black']); !!}
                    {!! Form::text('name',null,['class' => 'form-control','placeholder' => 'Nom','required']); !!}
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::label('description', 'Description', ['class' => 'section-title','style' => 'color:black']); !!}
                    {!! Form::textarea('description',null,['class' => 'form-control','placeholder' => 'Description','required','rows' => 3,'style' => 'resize:none']); !!}
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::label('begin', 'Date de début', ['class' => 'section-title','style' => 'color:black']); !!}
                    <div class='input-group date' id='begin'>
                        {!! Form::text('begin', \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$scheduleelement->begin)->toDateTimeString(), ['class' => 'form-control','required']); !!}
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::label('end', 'Date de fin', ['class' => 'section-title','style' => 'color:black']); !!}
                    <div class='input-group date' id='end'>
                        {!! Form::text('end', \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$scheduleelement->end)->toDateTimeString(), ['class' => 'form-control','required']); !!}
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::label('specialroles[]', 'Types d\'employés voulus', ['class' => 'section-title','style' => 'color:black']); !!}
                    {!! Form::select('specialroles[]',$specialRoles,$scheduleelement->specialroles->pluck('id'),['class' => 'form-control selectpicker','multiple' => 'multiple','data-actions-box' => 'true','required','id' => 'special_role']); !!}
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <section style="display: inline-flex">
                        <!-- .slideTwo -->
                        <div class="slideTwo">
                            <input checked="@if(count($scheduleelement->employees) > 0) true @else false @endif" type="checkbox" value="None" id="specific_user_checkbox" name="check"/>
                            <label for="specific_user_checkbox"></label>
                        </div>
                        <!-- end .slideTwo -->
                    </section>
                    <label class="text-center section-title" style="margin-left: 0.5em;color: black;">Employé spécifique</label>
                </div>
            </div>
            @if(count($scheduleelement->employees) > 0)
                {{-- Add multi select here --}}
                <div class="col-md-12" id="specific_user">
                    <div class="form-group">
                        {!! Form::label('users[]', 'Employés spécifiques voulus', ['class' => 'section-title','style' => 'color:black']); !!}
                        {!! Form::select('users[]',$availableEmployees,$employees,['class' => 'form-control selectpicker', 'multiple' => 'multiple','data-actions-box' => 'true']); !!}
                    </div>
                </div>
            @endif
        </div>
        <div class="col-md-12">
            <div class="col-md-12">
                <div class="form-group pull-left">
                    {!! Form::submit('Modifier',['class' => 'btn purplebtn','id' => 'submitUpdate']) !!}
                </div>
                {!! Form::close() !!}
                <div class="form-group pull-right">
                    {!! Form::open(['method' => 'DELETE','action' => ['ScheduleController@destroy',$scheduleelement->slug],'id' => 'deleteForm']) !!}
                    {!! Form::submit('Supprimer',['class' => 'pull-right btn btn-danger confirm_action','c_m_text' => 'Voulez-vous vraiment supprimer cet élément?','id' => 'submitDelete', 'style' => 'font-size: 17px!important']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        const cBox = document.getElementById('specific_user_checkbox');
        if (!cBox.checked)
            cBox.disabled = false;
        $('#begin').datetimepicker({
            useCurrent: false,
            date: new Date($('input[id=begin]').attr('value')),
            format: 'YYYY-MM-DD HH:mm:ss',
            locale: 'fr-ca'
        });
        $('#end').datetimepicker({
            useCurrent: false,
            date: new Date($('input[id=end]').attr('value')),
            format: 'YYYY-MM-DD HH:mm:ss',
            locale: 'fr-ca'
        });
        $('#specific_user_checkbox').change(function () {
            var data = $('#special_role option:selected').map(function() {
                return this.value
            }).get();
            getEmployeesByRole(data,12);
        });
        $('.selectpicker').selectpicker({});
        $('#special_role').change(function () {
            if ($('#specific_user')) {
                var data = $('#special_role option:selected').map(function() {
                    return this.value
                }).get();
                getEmployeesByRole(data,12);
                //getEmployeesByRole($('#special_role').find(":selected").val(),12);
            } else {
                // DO NOTHING.
            }
        });
    });
</script>