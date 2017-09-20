<?php

namespace App\Http\Controllers;

use App\CompanyType;
use App\JobOffer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Company;
use Illuminate\Support\Facades\Auth;

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
    public function store(Request $request)
    {
        $data = $request->all();
        $data["user_id"] = Auth::user()->id;
        Company::create($data);
        return $this->index();
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
        if ($data['user_id']!=Auth::id())
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
        if (Company::all()->get($id)->user_id !=Auth::id())
            return "pas le bon user";
        Company::destroy($id);
        return $this->index();
    }

//    public function delete($id,$user_id)
//    {
//        if ($user_id!=Auth::id())
//            return "pas le bon user";
//        Company::destroy($id);
//        return $this->index();
//    }

//    public function uploadphoto(Request $request)
//    {
//        $data = $request->except(['file','_method','_token']);
//        $file = $request->file('file');
//
//        // Encode image to base64
//        $filedata = file_get_contents($file);
//        $data['company_id'] = Auth::user()->id;
//        $data['source'] = base64_encode($filedata);
//
//        // Create profile picture in database
//        $user = Auth::user();
//        if ($user->photo)
//            $user->photo()->update($data);
//        else {
//            $photo = $user->photo()->create($data);
//            $user->photo_id = $photo->id;
//            $user->save();
//        }
//    }
//
//    public function photo() {
//        // return image as base64
//        return Auth::user()->photo;
//    }
}
