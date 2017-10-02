<?php

namespace App\Http\Controllers;

use App\Company;
use App\Http\Requests\CreateSkillRequest;
use App\Http\Requests\ModifySkillRequest;
use App\Skill;
use App\SpecialRole;
use Illuminate\Pagination\Paginator;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $skills = [];
        $specialRoles = SpecialRole::where('company_id',Company::findBySlugOrFail(session('CurrentCompany'))->id);
        foreach ($specialRoles->get() as $specialRole)
            foreach ($specialRole->skills as $skill)
                array_push($skills,$skill);
        $skills = new Paginator($skills,10,1);
        return view('skills.index',compact('skills'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('skills.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CreateSkillRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSkillRequest $request)
    {
        Skill::create($request->except(['_token','_method']));
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $slug
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $skill = Skill::findBySlugOrFail($slug);
        return view('skills.edit',compact('skill'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ModifySkillRequest  $request
     * @param  int  $slug
     * @return \Illuminate\Http\Response
     */
    public function update(ModifySkillRequest $request, $slug)
    {
        $data = $request->except(['_token','_method']);
        $skill = Skill::findBySlugOrFail($slug);
        $skill->update($data);
        return redirect('/skill');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $slug
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        Skill::findBySlugOrFail($slug)->delete();
        return redirect('/skill');
    }
}
