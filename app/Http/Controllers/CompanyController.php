<?php

namespace App\Http\Controllers;

use App\Company;
use App\CompanyType;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCompanyRequest;
use App\Http\Requests\ModifyCompanyRequest;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Config;

class CompanyController extends BaseController {
    /**
     * CompanyController constructor.
     */
	public function __construct() {
		$this->middleware('auth', ['except' => ['index', 'show','cpage','names','sort','sortCompanies']]);
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		if (Session::has('sortCompanies')) {
            $sesh = session('sortCompanies');
            $compagnies = Company::orderBy($sesh['column'],$sesh['order'])->get();
        } else {
            $compagnies = Company::all();
		    $sesh = [];
        }
		return view("company.index", compact('compagnies','sesh'));
	}

    /**
     * Data to fill company page.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function cpage(Request $request) {
        $page = $request->input('page');
        $name = $request->input('name');
        if (Session::has('sortCompanies')) {
            $sesh = session('sortCompanies');
            $data = Company::orderBy($sesh['column'],$sesh['order'])
                            ->where('description','like', "%". $name ."%")
                            ->orWhere('name', 'like',"%". $name ."%")
                            ->forPage($page, 4)
                            ->get();
        } else {
            $data = Company::where('description','like', "%". $name ."%")
                            ->orWhere('name', 'like',"%". $name ."%")
                            ->forPage($page, 4)
                            ->get();
        }
        return response()->json([
            'data' => $data,
            'canloadmore' => $data->count() > 0]
        );
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function names()
    {
        return response()->json(Company::pluck('name'));
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		$companyTypes = array();
		foreach (CompanyType::all() as $item) {
			$companyTypes[$item['id']] = $item['content'];
		}
		return view('company.create', compact('companyTypes'));
	}

    /**
     * @param CreateCompanyRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
	public function store(CreateCompanyRequest $request) {
		$data = $request->all();
        $data['user_id'] = Auth::user()->id;

        if (Session::has('CompanyPhoto')) {
			$data['photo'] = $request->session()->get('CompanyPhoto');
		}

		$data['pays'] = Config::get('countries')[$data['pays']];
		$company = Company::create($data);
        session(['CurrentCompany' => $company]);

        $employee = $company->employees()->create(['user_id' => Auth::user()->id]);
        $specialrole = $employee->specialroles()->create([
            'name' => 'Owner',
            'description' => 'Fondateur de l\'entreprise',
            'company_id' => $company->id
        ]);
        $specialrole->roles()->attach(Role::all()->where('content','<>','Administrator'));

		$request->session()->forget('CompanyPhoto');
		return redirect('/');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  string $slug
	 * @return \Illuminate\Http\Response
	 */
	public function show($slug) {
		$data = Company::findBySlugOrFail($slug);
		if ($data == null) {
			return redirect("company/index");
		}
		if (Session::has('sortCompany')) {
		    $sesh = session('sortCompany');
            $joboffers = $data->joboffers()->orderBy($sesh['column'],$sesh['order'])->paginate(5);
        } else {
            $joboffers = $data->joboffers()->orderBy('created_at','DESC')->paginate(5);
            $sesh = [];
        }
		return view('company.show', compact(['data', 'joboffers','sesh']));
	}

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
	public function sort(Request $request)
    {
        session(['sortCompany' => $request->all()]);
        return redirect()->action(
            'CompanyController@show',['slug' => $request->get('slug')]
        );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sortCompanies(Request $request)
    {
        session(['sortCompanies' => $request->all()]);
        return redirect()->action('CompanyController@index');
    }

    /**
	 * Show the form for editing the specified resource.
	 *
	 * @param  string $slug
	 * @return \Illuminate\Http\Response
	 */
	public function edit($slug) {
		$data = Company::findBySlugOrFail($slug);

		$companyTypes = [];
		foreach (CompanyType::all() as $item) {
			$companyTypes[$item->id] = $item->content;
		}

		return view('company.edit2', compact(['data', 'companyTypes']));
	}

    /**
     * @param Request $request
     */
	public function uploadphoto(Request $request) {
		// Encode image to base64
		session(['CompanyPhoto' => base64_encode(file_get_contents($request->file('file')))]);
	}

    /**
     * @param ModifyCompanyRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
	public function update(ModifyCompanyRequest $request, $id) {
		$data = $request->all();
        $data['pays'] = Config::get('countries')[$data['pays']];
		if ($data['user_id'] != Auth::id()) {
			return redirect()->back();
		}

		if (Session::has('CompanyPhoto')) {
			$data['photo'] = session()->get('CompanyPhoto');
		}

		Company::find($id)->update($data);
		return $this->show($data['name']);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		if (Company::all()->find($id)->user_id != Auth::id()) {
			return redirect()->back();
		}

		Company::destroy($id);
		return redirect()->action("CompanyController@index");
	}

    /**
     * @param $slug
     * @return \Illuminate\Http\RedirectResponse
     */
	public function select($slug) {
		$company = Company::findBySlugOrFail($slug);
		session(['CurrentCompany' => $company]);
		return redirect()->back();
	}
}
