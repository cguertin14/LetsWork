@component('components.modal')

    @slot('title')
        Ajouter un employé
    @endslot

    @slot('body')
        @if ($specialroles->count() > 0)
            {!! Form::open(['method' => 'POST','action' => 'EmployeeController@store', 'id' => 'createForm']) !!}
            <div class="row">
                <div class="col-md-12" id="container">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('user_slug', 'Choisir un utilisateur', ['class' => 'section-title']); !!}
                            {!! Form::select('user_slug',$users,null,['class' => 'form-control','required']); !!}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('special_role_slug', 'Choisir un poste', ['class' => 'section-title']); !!}
                            {!! Form::select('special_role_slug',$specialroles,null,['class' => 'form-control','required']); !!}
                        </div>
                    </div>
                    <div class="col-md-12" id="errorsParent" style="display: none;">
                        <div class="form-group" id="errors">
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        @else
            <div class="col-md-12 text-center">
                Vous devez ajouter des postes pour pouvoir ajouter des employés.
            </div>
        @endif
    @endslot

    @slot('submitbtn')
        @if ($specialroles->count() > 0)
            <button id="createBtn" class="btn purplebtn">Créer</button>
        @endif
    @endslot

    @slot('events') @endslot

@endcomponent