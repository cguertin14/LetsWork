<?php

namespace App\Http\Controllers;

use App\Company;
use App\Http\Requests\CreateSpecialRoleRequest;
use App\Role;
use App\Skill;
use App\SpecialRole;
use Illuminate\Http\Request;

class SpecialRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $specialRoles = SpecialRole::paginate(10);
        return view('specialrole.index',compact('specialRoles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('content','id')->all();
        $skills = Skill::pluck('name','id')->all();
        return view('specialrole.create',compact('roles','skills'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSpecialRoleRequest $request)
    {
        // Création de rôle spécial
        $data = $request->except('_token');
        $data['company_id'] = Company::findBySlugOrFail(session('CurrentCompany'))->id;
        $specialRole = SpecialRole::create($data);

        foreach($request->roles as $role)
            $specialRole->roles()->attach($role);
        foreach($request->skills as $skill)
            $specialRole->skills()->attach($skill);

        return redirect('/specialrole');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
