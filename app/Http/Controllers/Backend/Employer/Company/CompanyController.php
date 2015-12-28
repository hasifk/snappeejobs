<?php

namespace App\Http\Controllers\Backend\Employer\Company;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
{
    public function showProfile(){
        $company = [];
        $view = $company;
        return view('backend.employer.company.showprofile', $view);
    }

    public function editProfile(){
        return view('backend.employer.company.editprofile');
    }

    public function updateProfile(Request $request){

    }


}
