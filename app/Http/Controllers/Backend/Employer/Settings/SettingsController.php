<?php

namespace App\Http\Controllers\Backend\Employer\Settings;

use App\Http\Requests\Backend\Employer\Staff\EmployerChoosePlanRequest;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.employer.settings.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function plan()
    {
        return view('backend.employer.settings.plan');
    }

    public function choosePlan(EmployerChoosePlanRequest $request, $plan){

        $planDetails = config('subscription.employer_plans.' . $plan);

        return view('backend.employer.settings.chooseplan', [ 'plan' => $planDetails ]);
    }

}
