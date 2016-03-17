<?php

namespace App\Http\Controllers\Backend\AdminMail;

use App\Models\Company\Company;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminMailController extends Controller
{

    public function index()
    {

        $companies = Company::select(['id', 'title'])->get();
        $to_users = [];

        $view = [
            'companies' => $companies
        ];

        return view('backend.admin.mail.index', $view);
    }

    public function getCompanyUsers(Request $request, $company_id){
        $employer_id = \DB::table('companies')->where('id', $company_id)->value('employer_id');

        $users = \DB::table('users')->where('employer_id', $employer_id)->select(['id', 'name'])->get();

        return response()->json($users);
    }

}
