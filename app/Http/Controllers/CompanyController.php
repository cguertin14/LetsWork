<?php

namespace App\Http\Controllers;

use App\CompanyType;
use App\Http\Requests\CreateCompanyRequest;
use App\Http\Requests\ModifyCompanyRequest;
use App\JobOffer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','show']]);
    }
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
    public function store(CreateCompanyRequest $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        if (Session::has('CompanyPhoto'))
            $data['photo'] = $request->session()->get('CompanyPhoto');
        Company::create($data);
        $request->session()->forget('CompanyPhoto');
        $request->session()->flush();
        return $this->index();
    }

    /**
     * Display the specified resource.
     *
     * @param  string $name
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
     * @param  string $name
     * @return \Illuminate\Http\Response
     */
    public function edit($name)
    {
        $data=Company::all()->where('name','=',$name)->first();
        if($data==null)
            return redirect()->back();
        if ($data['user_id']!=Auth::id()) /////// Auth::id() ??? --> Auth::user()->id
            return redirect()->back();
        $companyTypes = array();
        foreach (CompanyType::all() as $item) {
            $companyTypes[$item['id']] = $item['content'];
        }
        return view('company.edit',compact(['data','companyTypes']));
    }

    public function uploadphoto(Request $request)
    {
        $file = $request->file('file');
        // Encode image to base64
        $filedata = file_get_contents($file);
        session(['CompanyPhoto' => base64_encode($filedata)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ModifyCompanyRequest $request, $id)
    {
        $data = $request->all();
        if ($data['user_id']!=Auth::id())
            return redirect()->back();
        Company::find($id)->update($data);
        return $this->show($data['name']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Company::all()->find($id)->user_id !=Auth::id())
            return redirect()->back();
        Company::destroy($id);
        return redirect()->action("CompanyController@index");
    }

    public function select($slug)
    {
        $company = Company::findBySlugOrFail($slug);
        session(['CurrentCompany' => $company->slug]);
        return redirect()->back();
    }
}
