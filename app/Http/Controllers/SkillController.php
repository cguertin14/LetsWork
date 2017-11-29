<?php

namespace App\Http\Controllers;

use App\Company;
use App\Http\Requests\CreateSkillRequest;
use App\Http\Requests\ModifySkillRequest;
use App\Skill;
use App\SpecialRole;
use App\Tools\Helper;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Session;

class SkillController extends BaseController
{
    /**
     * SkillController constructor.
     */
    public function __construct()
    {
        $this->middleware('highranked',['only' => ['create','edit','destroy','store','update']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (self::CCompany() == null)
            return redirect('/');
        if (Session::has('sortSkills')) {
            $sesh = session('sortSkills');
            $skills = self::CCompany()->skills()->orderBy($sesh['column'],$sesh['order'])->paginate(10);
        } else {
            $skills = self::CCompany()->skills()->paginate(10);
            $sesh = [];
        }
        return view('skills.index',compact('skills','sesh'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sort(Request $request)
    {
        session(['sortSkills' => ['column' => $request->column,'order' => $request->order]]);
        return redirect()->action('SkillController@index');
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
        $data = $request->except(['_token','_method']);
        $data['company_id'] = $this->CCompany()->id;
        Skill::create($data);
        return redirect('/skill');
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
