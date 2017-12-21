<div id="employeesGrid" style="margin-bottom: 1.5em;">
    @if ($employees->count() > 0)
        <div class="row layout text-center">
            <div class="centre custom-container row" style="padding: 1em">
                @foreach($employees->chunk(3) as $employees2)
                    <div class="row">
                        @php($i = 0)
                        @foreach ($employees2 as $employee)
                            <div class="col-sm-4">
                                <div class="card">
                                    <img class="profile-image" style="overflow: hidden;border-radius: 50%;margin-top: 1.5em;" src="@if ($employee->user->photo) data:image/png;base64,{{$employee->user->photo->source}} @else {{asset('image/default-profile.png')}} @endif">
                                    <h1 class="fullname" style="overflow: hidden;">{{$employee->user->fullname}}</h1>
                                    <p style="overflow: hidden;" class="title">{{$employee->specialroles()->get()->first()->name}}</p>
                                    <p>{{\App\Tools\Helper::CCompany()->name}}</p>
                                    <a style="overflow: hidden;bottom: 0;position: absolute;left: 0;right: 0;margin-bottom: 1em;margin-right: 2em;margin-left: 2em" href="{{route('punches.employee',$employee->id)}}" class="btn purplebtn">Voir les heures</a>
                                </div>
                            </div>
                            @php(++$i)
                        @endforeach
                    </div>
                @endforeach
            </div>
            <br>
        </div>
    @else
        <div class="row layout">
            <div class="centre custom-container">
                <div style="background-color:#707070;padding: 3em; text-align: center;font-size: 2em;color: white;font-family: 'Ubuntu', sans-serif;font-style: italic">
                    Aucun employé n'a été trouvé
                </div>
            </div>
        </div>
    @endif
</div>