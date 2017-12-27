<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Http\Requests\CreateEmployeeRequest;
use App\SpecialRole;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class EmployeeController extends BaseController
{
    /**
     * EmployeeController constructor.
     */
    public function __construct()
    {
        $this->middleware('highranked');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::query()->whereDoesntHave('employees')->whereDoesntHave('companies')->get();
        $employees = self::CCompany()->employees()->where('user_id','<>',Auth::id())->get()->unique();
        return view('employees.index',compact('employees','users'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function employeesNames()
    {
        return response()->json([
            'employees' => self::CCompany()->employees()->where('user_id','<>',Auth::id())->get()->map(function ($employee) { return $employee->user->fullname; })->unique()
        ]);
    }

    /**
     * @param $keyword
     * @return string
     */
    public function sortEmployees($keyword)
    {
        $employees = self::CCompany()->employees()->where('user_id','<>',Auth::id())->get()->filter(function (Employee $employee) use ($keyword) {
            return stristr($employee->user->fullname,$keyword);
        })->unique();
        return view('employees.employees_grid',compact('employees'))->render();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function employeesAll()
    {
        $employees = self::CCompany()->employees()->get()->where('user_id','<>',Auth::id())->unique();
        $users = User::query()->whereDoesntHave('employees')->whereDoesntHave('companies')->get()->count();
        return response()->json([
            'view' => view('employees.employees_grid',compact('employees'))->render(),
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::query()->whereDoesntHave('employees')->whereDoesntHave('companies')->get()->pluck('fullname','slug');
        $specialroles = self::CCompany()->specialroles()->pluck('name','slug');
        return view('employees.create',compact('users','specialroles'));
    }

    /**
     * @param CreateEmployeeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateEmployeeRequest $request)
    {
        $payload = $request->only('user_slug','special_role_slug');

        $employee = User::findBySlugOrFail($payload['user_slug'])->employees()->create();
        SpecialRole::findBySlugOrFail($payload['special_role_slug'])->employees()->attach($employee);
        self::CCompany()->employees()->attach($employee);
        $employee->companies()->attach(self::CCompany());

        return response()->json([
            'status' => 'Employee successfully created!'
        ],201);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = Employee::query()->findOrFail($id);
        $specialroles = self::CCompany()->specialroles()->pluck('name','slug');
        $specialrole = $employee->specialroles()->first()->slug;
        return view('employees.edit',compact('employee','specialroles','specialrole'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        // Get employee
        $employee = Employee::query()->findOrFail($id);

        $payload = $request->only('special_role_slug');
        $specialRole = SpecialRole::findBySlugOrFail($payload['special_role_slug']);
        $employee->specialroles()->detach($employee->specialroles()->first());
        $employee->specialroles()->attach($specialRole);

        return response()->json([
            'status' => 'Special role successfully updated'
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Employee::query()->findOrFail($id)->delete();
        return response()->json([
            'status' => 'Employee successfully deleted!'
        ], 201);
    }
}
