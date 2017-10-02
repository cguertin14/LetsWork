<?php

namespace App\Http\Controllers;

use App\Company;
use App\Http\Requests\CreateSpecialRoleRequest;
use App\Http\Requests\UpdateSpecialRoleRequest;
use App\Role;
use App\Skill;
use App\SpecialRole;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class SpecialRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $specialRoles = SpecialRole::where('company_id',Company::findBySlugOrFail(session('CurrentCompany'))->id)->get();
        $specialRoles = new Paginator($specialRoles,10,1);
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
    public function edit($slug)
    {
        $specialRole = SpecialRole::findBySlugOrFail($slug);
        $roles = Role::pluck('content','id')->all();
        $skills = Skill::pluck('name','id')->all();
        return view('specialrole.edit',compact('specialRole','skills','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSpecialRoleRequest $request, $slug)
    {
        $data = $request->except(['_token','_method','skills','roles']);
        $specialRole = SpecialRole::findBySlugOrFail($slug);

        // Detach first
        $this->detachRoles($request,$specialRole);
        $this->detachSkills($request,$specialRole);

        // Attach after
        $this->attachRoles($request,$specialRole);
        $this->attachSkills($request,$specialRole);

        $specialRole->update($data);
        return redirect('/specialrole');
    }

    public function attachSkills($request,$specialRole)
    {
        $skills = [];
        $realSkills = [];

        foreach ($request->skills as $skillID)
            array_push($skills,Skill::findOrFail($skillID));
        foreach ($specialRole->skills as $skill)
            array_push($realSkills,Skill::findOrFail($skill->id));

        $skillsToAttach = array_diff($skills,$realSkills);

        foreach ($skillsToAttach as $skillToAttach)
            $specialRole->skills()->attach($skillToAttach);
    }

    public function attachRoles($request,$specialRole)
    {
        $roles = [];
        $realRoles = [];

        foreach ($request->roles as $roleID)
            array_push($roles,Role::findOrFail($roleID));
        foreach ($specialRole->roles as $role)
            array_push($realRoles,Role::findOrFail($role->id));

        $rolesToAttach = array_diff($roles,$realRoles);

        foreach ($rolesToAttach as $roleToAttach)
            $specialRole->roles()->attach($roleToAttach);
    }

    public function detachSkills($request,$specialRole)
    {
        $skills = [];
        $realSkills = [];

        foreach ($request->skills as $skillID)
            array_push($skills,Skill::findOrFail($skillID));
        foreach ($specialRole->skills as $skill)
            array_push($realSkills,Skill::findOrFail($skill->id));

        $skillsToDetach = array_diff($realSkills,$skills);

        if (!empty($skillsToDetach))
            foreach ($skillsToDetach as $skillToDetach)
                $specialRole->skills()->detach($skillToDetach);
    }

    public function detachRoles($request,$specialRole)
    {
        $roles = [];
        $realRoles = [];
        foreach ($request->roles as $roleID)
            array_push($roles,Role::findOrFail($roleID));
        foreach ($specialRole->roles as $role)
            array_push($realRoles,Role::findOrFail($role->id));

        $rolesToDetach = array_diff($realRoles,$roles);

        if (!empty($rolesToDetach))
            foreach ($rolesToDetach as $roleToDetach)
                $specialRole->roles()->detach($roleToDetach);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        SpecialRole::findBySlugOrFail($slug)->delete();
        return redirect('/specialrole');
    }
}
