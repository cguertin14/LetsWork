@component('components.modal')

    @slot('title')
        Modifier un employé
    @endslot

    @slot('body')
        {!! Form::open(['method' => 'PATCH','action' => ['EmployeeController@update', $employee->id],'id' => 'editForm']) !!}
            <div class="row">
                <div class="col-md-12" id="container">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('user_slug', 'Nom de l\'employé', ['class' => 'section-title']); !!}
                            {!! Form::text('user_slug',$employee->user->fullname,['class' => 'form-control','disabled']); !!}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('special_role_slug', 'Changer le poste', ['class' => 'section-title']); !!}
                            {!! Form::select('special_role_slug',$specialroles,$specialrole,['class' => 'form-control','required']); !!}
                        </div>
                    </div>
                    <div class="col-md-12" id="errorsParent" style="display: none;">
                        <div class="form-group" id="errors">
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::submit('Submit',['class' => 'btn purblebtn','style' => 'display:none','id' => 'submit']) !!}
        {!! Form::close() !!}
        {!! Form::open(['method' => 'DELETE','action' => ['EmployeeController@destroy', $employee->id],'id' => 'deleteForm']) !!}
        {!! Form::close() !!}
    @endslot

    @slot('submitbtn')
        <button id="editBtn" href="" class="btn btn-warning pull-left">Modifier</button>
        <button id="deleteBtn" href="" class="btn btn-danger">Supprimer</button>
    @endslot

    @slot('events')
    @endslot

@endcomponent