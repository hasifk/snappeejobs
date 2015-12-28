<?php

namespace App\Http\Controllers\Backend\Employer\Settings;

use App\Http\Requests\Backend\Employer\Staff\EmployerChoosePlanRequest;
use App\Repositories\Backend\Employer\EloquentStaffRepository;
use App\Repositories\Backend\Permission\PermissionRepositoryContract;
use App\Repositories\Backend\Role\RoleRepositoryContract;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{

    /**
     * @var EloquentStaffRepository
     */
    private $staffs;
    /**
     * @var RoleRepositoryContract
     */
    private $roles;
    /**
     * @var PermissionRepositoryContract
     */
    private $permissions;

    public function __construct(EloquentStaffRepository $staffs, RoleRepositoryContract $roles, PermissionRepositoryContract $permissions)
    {

        $this->staffs = $staffs;
        $this->roles = $roles;
        $this->permissions = $permissions;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $subscribed = false;

        if ( auth()->user()->subscribed() ) {
            $current_plan = array_where(config('subscription.employer_plans'), function($key, $value){
                return $value['id'] == auth()->user()->stripe_plan;
            });
            $current_plan = head($current_plan);
            $subscribed = true;
        } else {
            $current_plan = null;
        }

        $view = [
            'subscribed'    => $subscribed,
            'plan'          => $current_plan
        ];

        return view('backend.employer.settings.index', $view);
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

    public function subscribe(Requests\Backend\Employer\Settings\EmployerSubscribePlanRequest $request, $plan){

        $planDetails = config('subscription.employer_plans.' . $plan);

        auth()->user()->subscription($planDetails['id'])->create($request->get('stripeToken'), [
            'email'         => auth()->user()->email,
            'description'   => $planDetails['description']
        ]);

        auth()->user()->save();

        $this->staffs->employerPlanSave($planDetails, auth()->user());

        return redirect()
            ->route('admin.employer.settings.dashboard')
            ->withFlashSuccess('You have successfully subscribed to the plan : '.$planDetails['name']);

    }

}
