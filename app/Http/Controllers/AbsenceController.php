<?php

namespace App\Http\Controllers;

use App\Absence;
use App\Company;
use App\Employee;
use App\Http\Requests\CreateAbsenceRequest;
use App\Tools\Collection;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidDateException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AbsenceController extends BaseController
{
    /**
     * AbsenceController constructor.
     */
    public function __construct()
    {
        $this->middleware('highranked',['only' => ['update','destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Session::has('sortAbsences')) {
            $sesh = session('sortAbsences');
            if ($sesh['column'] === 'employee') {
                if (self::CIsHighRanked()) {
                    $absences = (new Collection(self::CCompany()->employees()->join('users', 'employees.user_id', '=', 'users.id')->orderBy('users.name', $sesh['order'])->get()
                    ->map(function (Employee $employee) use ($sesh) {
                        return $employee->absences()->get()->first();
                    })->filter(function ($element) {
                        return $element != null && count($element) > 0;
                    })))->unique()->where('end','>',Carbon::now()->toDateTimeString())->paginate(10);
                } else if (self::CIsEmployee()) {
                    $absences = (new Collection(self::CCompany()->employees()->join('users', 'employees.user_id', '=', 'users.id')->where('users.id',Auth::id())->orderBy('users.name', $sesh['order'])->get()
                    ->map(function (Employee $employee) use ($sesh) {
                        return $employee->absences()->get()->first();
                    })->filter(function ($element) {
                        return $element != null && count($element) > 0;
                    })))->unique()->where('end','>',Carbon::now()->toDateTimeString())->paginate(10);
                }
            } else {
                if (self::CIsHighRanked()) {
                    $absences = (new Collection(self::CCompany()->employees()->get()->map(function (Employee $employee) use ($sesh) {
                        return $employee->absences()->orderBy($sesh['column'], $sesh['order'])->get()->first();
                    })->filter(function ($element) {
                        return $element != null;
                    })))->unique()->where('end','>',Carbon::now()->toDateTimeString())->paginate(10);
                } else {
                    $absences = (new Collection(self::CCompany()->employees()->where('user_id',Auth::id())->get()->map(function (Employee $employee) use ($sesh) {
                        return $employee->absences()->orderBy($sesh['column'], $sesh['order'])->get()->first();
                    })->filter(function ($element) {
                        return $element != null;
                    })))->unique()->where('end','>',Carbon::now()->toDateTimeString())->paginate(10);
                }
            }
        } else {
            if (self::CIsHighRanked()) {
                $absences = (new Collection(self::CCompany()->employees()->get()->map(function(Employee $employee) {
                    return $employee->absences()->get()->first();
                })->filter(function($element) {
                    return $element != null;
                })))->unique()->where('end','>',Carbon::now()->toDateTimeString())->paginate(10);
            } else if (self::CIsEmployee()) {
                $absences = (new Collection(self::CCompany()->employees()->get()->where('user_id',Auth::id())->map(function(Employee $employee) {
                    return $employee->absences()->get()->first();
                })->filter(function($element) {
                    return $element != null;
                })))->unique()->where('end','>',Carbon::now()->toDateTimeString())->paginate(10);
            }
            $sesh = [];
        }
        return view('absence.index',compact('sesh','absences'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sort(Request $request)
    {
        session(['sortAbsences' => $request->all()]);
        return redirect()->action('AbsenceController@index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Session::has('CurrentCompany')) {
            $company = session('CurrentCompany');
            return view('absence.create', compact('company'));
        } else {
            if (self::CIsHighRanked())
                return redirect()->action('AbsenceController@index');
            else
                return redirect()->back();
        }
    }

    /**
     * @param CreateAbsenceRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(CreateAbsenceRequest $request)
    {
        $data = $request->except('_token');
        $data['employee_id'] = self::CEmployee()->id;

        $datebegin = Carbon::parse($data['begin']);
        $dateend = Carbon::parse($data['end']);

        if ($datebegin->gt($dateend) || $datebegin->eq($dateend)) {
            session()->flash('errorAbsence','La date de début doit être inférieure à la date de fin!');
            return redirect()->back();
        }

        $data['begin'] = $datebegin->toDateTimeString();
        $data['end'] = $dateend->toDateTimeString();
        Absence::create($data);

        return self::CIsHighRanked() ? redirect()->action('AbsenceController@index') : redirect('/');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $absence = Absence::findBySlugOrFail($slug);
        $absence->approved = $request->input('approved');
        $absence->save();
        return redirect()->action('AbsenceController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        Absence::findBySlugOrFail($slug)->delete();
        return redirect()->action('AbsenceController@index');
    }
}
