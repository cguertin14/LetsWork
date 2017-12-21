<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;

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
        $employees = self::CCompany()->employees()->get();
        return view('employees.index',compact('employees'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function employeesNames()
    {
        return response()->json([
            'employees' => self::CCompany()->employees()->get()->map(function ($employee) { return $employee->user->fullname; })
        ]);
    }

    /**
     * @param $keyword
     * @return string
     */
    public function sortEmployees($keyword)
    {
        $employees = self::CCompany()->employees()->get()->filter(function (Employee $employee) use ($keyword) {
            return stristr($employee->user->fullname,$keyword);
        });
        return view('employees.employees_grid',compact('employees'))->render();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function employeesAll()
    {
        $employees = self::CCompany()->employees()->get();
        return view('employees.employees_grid',compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // @todo
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // @todo
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // @todo
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // @todo
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // @todo
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // @todo
    }
}
