<?php

namespace App\Http\Controllers;

use App\CompanyType;
use App\JobOffer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $compagnies=Company::all();
        return view("company.index", compact('compagnies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companyTypes = array();
        foreach (CompanyType::all() as $item) {
            $companyTypes[$item['id']] = $item['content'];
        }
        return view('company.create', compact('companyTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data["user_id"] = Auth::user()->id;
        Company::create($data);
        return "Bravo compagnie creer";
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($name)
    {
        $data=Company::all()->where('name','=',$name)->first();
        if($data==null) {
            return redirect("company/index");
        }
        $joboffers=$data->joboffers;
        return view('company.show',compact(['data','joboffers']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($name)
    {
        $data=Company::all()->where('name','=',$name)->first();
        if($data==null)
            return redirect()->back();
        $companyTypes = array();
        foreach (CompanyType::all() as $item) {
            $companyTypes[$item['id']] = $item['content'];
        }
        return view('company.edit',compact(['data','companyTypes']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        Company::find($id)->update($data);
        return "Bravo compagnie modifier";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function select($slug)
    {
        $company = Company::findBySlugOrFail($slug);
        session(['CurrentCompany' => $company->slug]);
        return redirect()->back();
    }
}
