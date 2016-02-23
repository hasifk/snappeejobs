<?php

namespace App\Http\Controllers\Backend\Company;

use App\Models\Company\Company;
use App\Repositories\Backend\Admin\Company\EloquentCompanyRepository;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class AdminCompanyController extends Controller
{
    /**
     * @var EloquentCompanyRepository
     */
    private $companyRepository;

    /**
     * AdminCompanyController constructor.
     * @param EloquentCompanyRepository $companyRepository
     */
    public function __construct(EloquentCompanyRepository $companyRepository)
    {

        $this->companyRepository = $companyRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.admin.companies.index')
            ->withCompanies($this->companyRepository->getCompaniesPaginated(config('jobs.default_per_page')));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $company = Company::findOrFail($id);

        return view('backend.admin.companies.show', ['company' => $company]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {

        $company = Company::findOrFail($id);

        $industries = \DB::table('industries')->select(['id', 'name'])->get();
        $countries = \DB::table('countries')->select(['id', 'name'])->get();

        if ( $request->old('country_id') || ( $company && $company->country_id ) ) {
            $country_id = $request->old('country_id') ? $request->old('country_id') : $company->country_id;
            $states = \DB::table('states')->where('country_id', $country_id)->select(['id', 'name'])->get();
        } else {
            $states = \DB::table('states')->where('country_id', 222)->select(['id', 'name'])->get();
        }

        $view = [
            'company'       => $company,
            'countries'     => $countries,
            'states'        => $states,
            'industries'    => $industries
        ];
        return view('backend.admin.companies.edit', $view);

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
        $this->companyRepository->update($request, $id);

        return redirect()
            ->route('admin.company.index')
            ->withFlashSuccess('Successfully updated the company profile');
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
