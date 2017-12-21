<div id="employeesTable">
    @if ($punches->count() > 0)
        <table class="table custom-table" style="margin: 0px !important;">
            <thead>
            <tr class="section-title">
                <th>Employé <span id="sortEmployee" v-on:click="sortEmployee()" class="sort"></span></th>
                <th>Début <span id="sortDateDebut" v-on:click="sortDateDebut()" class="sort"></span></th>
                <th>Fin <span id="sortDateFin" v-on:click="sortDateFin()" class="sort"></span></th>
                <th>Durée <span id="sortDuration" v-on:click="sortDuration()" class="sort"></span></th>
            </tr>
            </thead>
            <tbody class="section">
                @php($i = 0)
                @foreach($punches as $punch)
                    <tr style="cursor:default;" class="@if ($i % 2 == 0 ) section-index-2 @else section-index @endif">
                        @php(\Carbon\Carbon::setLocale('fr'))
                        <td>{{$punch->employee->user->fullname}}</td>
                        <td>{{\Carbon\Carbon::parse($punch->datebegin)->toDateTimeString()}}</td>
                        <td>{{\Carbon\Carbon::parse($punch->dateend)->toDateTimeString()}}</td>
                        @if($punch->dateend)
                            <td>{{\Carbon\Carbon::parse($punch->dateend)->diffForHumans(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$punch->datebegin),true)}}</td>
                        @else
                            <td>Période de travail non terminée</td>
                        @endif
                    </tr>
                    @php(++$i)
                @endforeach
            </tbody>
        </table>
        <div class="row">
            <div class="text-center">
                {{$punches->render('pagination.paginate')}}
            </div>
        </div>
    @else
        <div style="background-color:#707070;padding: 3em; text-align: center;font-size: 2em;color: white;font-family: 'Ubuntu', sans-serif;font-style: italic">
            Aucun employé trouvé
        </div>
    @endif
</div>