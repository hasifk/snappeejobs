<?php

namespace App\Http\Controllers\Backend\Employer\Settings;

use App\Exceptions\Backend\Access\Employer\EmployerNeedsRolesException;
use App\Http\Requests\Backend\Employer\Staff\EmployerChoosePlanRequest;
use App\Models\Access\User\User;
use App\Models\Company\Company;
use App\Models\Job\Job;
use App\Repositories\Backend\Employer\EloquentStaffRepository;
use App\Repositories\Backend\Logs\LogsActivitysRepository;
use App\Repositories\Backend\Permission\PermissionRepositoryContract;
use App\Repositories\Backend\Role\RoleRepositoryContract;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Activity;

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
    private $userLogs;

    public function __construct(EloquentStaffRepository $staffs, RoleRepositoryContract $roles, PermissionRepositoryContract $permissions,
LogsActivitysRepository $userLogs)
    {

        $this->staffs = $staffs;
        $this->roles = $roles;
        $this->permissions = $permissions;
        $this->userLogs = $userLogs;
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
        $array['type'] = 'Subscription Plan';
        $array['heading']='of User:'.auth()->user()->name;
        if($this->staffs->employerPlanSave($planDetails, auth()->user()))
        {
            $array['event'] = 'updated';

            $name = $this->userLogs->getActivityDescriptionForEvent($array);
            Activity::log($name);
        }

        return redirect()
            ->route('admin.employer.settings.dashboard')
            ->withFlashSuccess('You have successfully subscribed to the plan : '.$planDetails['name']);

    }

    public function chooseplanupgrade(Requests\Backend\Employer\Settings\EmployerChooseUpgradePlanRequest $request)
    {

        $planDetails = config('subscription.employer_plans.' . auth()->user()->EmployerSubscriptionPlan);

        $plans = config('subscription.employer_plans');

        return view('backend.employer.settings.chooseupgrade', [
            'subscription_plan' => $planDetails,
            'plans'=> $plans
        ]);

    }

    public function upgradeplan(Requests\Backend\Employer\Settings\EmployerUpgradePlanRequest $request)
    {

        auth()->user()->subscription($request->get('plan_id'))->swap();

        return redirect()
            ->route('admin.employer.settings.dashboard')
            ->withFlashSuccess('You have successfully upgraded your subscription plan. ');

    }

    public function usage(Request $request){

        $planUsage = auth()->user()->employerPlan;
        $employerAdmin = User::find(auth()->user()->employer_id);
        $planDetails = config('subscription.employer_plans.' . $employerAdmin->EmployerSubscriptionPlan);
        $addonPakcs = config('subscription.addons_packs');

        return view('backend.employer.settings.usage', [
            'plan_usage' => $planUsage,
            'plan_details'=> $planDetails,
            'addonpacks' => $addonPakcs
        ]);
    }
    public function makepaid(){


        $companypaidpack = config('subscription.company_makepaid');
        $companyAdmin = auth()->user()->employer_id;
        $companyAdmin1 = auth()->user()->company_id;
        $company_info=Company::where('employer_id',$companyAdmin)->first();

        if (! $company_info ) {
            $exception = new EmployerNeedsRolesException();
            $exception->setValidationErrors('Please fill in the company details first.');

            throw $exception;
        }

        $job_list=Job::where('company_id',$companyAdmin1)->get();

        return view('backend.employer.settings.make_paid', [

            'companypaidpack' => $companypaidpack,
            'job_list'       => $job_list,
            'company_info'       => $company_info
        ]);
    }

    public function buyaddon(Request $request, $addon){

        $addons = [
            'job_postings'      => "Job Postings",
            'staff_members'     => 'Staff members',
            'chats_accepted'    => 'Chats Accepted'
        ];

        return view('backend.employer.settings.buyaddon.addon.buy', [
            'addon'     => $addon,
            'addons'    => $addons
        ]);
    }
    
    public function buyaddonAction(Requests\Backend\Employer\Settings\EmployerBuyAddonRequest $request, $addon){

        $addon_price = config('subscription.addon_prices.' . $addon) * $request->get('addonvalue');

        $employerPlan = \DB::table('employer_plan')->where('employer_id', auth()->user()->employer_id)->first();

        $employerAdmin = User::find(auth()->user()->employer_id);
        $charged = $employerAdmin->charge($addon_price*100);

        if ( $charged ) {
            \DB::table('employer_plan')->where('employer_id', auth()->user()->employer_id)->update([
                $addon      => $employerPlan->{"$addon"} + $request->get('addonvalue'),
                'updated_at'        => Carbon::now()
            ]);

            \DB::table('employer_addon_history')->insert([
                'employer_id'       => auth()->user()->employer_id,
                'addon_type'        => $addon,
                'addon'             => $request->get('addonvalue'),
                'price'             => $addon_price,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ]);

            $array['type'] = 'Addon';
            $array['heading']='of Type:'.$addon.'  is purchased by'.auth()->user()->name;
            $array['event'] = 'purchased';
            $name = $this->userLogs->getActivityDescriptionForEvent($array);
            Activity::log($name);

            return redirect()
                ->route('admin.employer.settings.usage')
                ->withFlashSuccess('You have successfully purchased the add on.');
        }

        return redirect()
            ->route('admin.employer.settings.usage')
            ->withErrors('We were unable to charge your credit card, please try again later');
    }

    public function buyaddonpack(Request $request, $pack){
        $selectedPack = config('subscription.addons_packs.'. $pack);

        return view('backend.employer.settings.buyaddon.pack.buy', [
            'selected_pack' => $selectedPack,
            'pack'          => $pack
        ]);
    }

    public function buyaddonpackAction(Request $request, $pack){

        $selectedPack = config('subscription.addons_packs.'. $pack);
        $employerAdmin = User::find(auth()->user()->employer_id);
        $charged = $employerAdmin->charge($selectedPack['price']*100);

        if ( $charged ) {

            $employerPlan = \DB::table('employer_plan')->where('employer_id', auth()->user()->employer_id)->first();

            \DB::table('employer_plan')->where('employer_id', auth()->user()->employer_id)->update([
                'job_postings'      => $employerPlan->job_postings + $selectedPack['job_postings'],
                'staff_members'     => $employerPlan->staff_members + $selectedPack['staff_members'],
                'chats_accepted'    => $employerPlan->chats_accepted + $selectedPack['chats_accepted'],
                'updated_at'        => Carbon::now(),
            ]);

            // Add to history
            \DB::table('employer_addon_pack_history')->insert([
                'employer_id'       => auth()->user()->employer_id,
                'pack'              => $pack,
                'job_postings'      => $selectedPack['job_postings'],
                'staff_members'     => $selectedPack['staff_members'],
                'chats_accepted'    => $selectedPack['chats_accepted'],
                'price'             => $selectedPack['price'],
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ]);

            $array['type'] = 'AddonPack';
            $array['heading']='of Type:'.$pack.'  is purchased by'.auth()->user()->name;
            $array['event'] = 'purchased';
            $name = $this->userLogs->getActivityDescriptionForEvent($array);
            Activity::log($name);

            return redirect()
                ->route('admin.employer.settings.usage')
                ->withFlashSuccess('You have successfully purchased the add on pack.');

        }

        return redirect()
            ->route('admin.employer.settings.usage')
            ->withErrors('Unable to charge your credit card, please try again. ');

    }


    public function savecmppaid(Requests\Backend\Employer\Settings\MakeCompanyPaidRequest $request){

        $employerAdmin = User::find(auth()->user()->employer_id);
        $charged = $employerAdmin->charge(config('subscription.company_makepaid.price')*100);
        $expiry=Carbon::now()->addSeconds(config('subscription.company_makepaid.time_frame'));

        if ( $charged ) {

            $update_company=Company::find(auth()->user()->company_id);
            $update_company->paid=1;
            $update_company->paid_expiry=$expiry;
            $update_company->save();

            $array['type'] = 'Paid Company';
            $array['heading']='Status of :'.auth()->user()->company_name;
            $array['event'] = 'updated';
            $name = $this->userLogs->getActivityDescriptionForEvent($array);
            Activity::log($name);
            return redirect()
                ->route('admin.employer.settings.makepaid')
                ->withFlashSuccess('Your Company successfully became paid .');
        }

        return redirect()
            ->route('admin.employer.settings.makepaid')
            ->withErrors('We were unable to charge your credit card, please try again later');
    }



    public function savejobpaid(Requests\Backend\Employer\Settings\MakeJobPaidRequest $request){
        $job_id=$request->input('job_id');
        $employerAdmin = User::find(auth()->user()->employer_id);
        $charged = $employerAdmin->charge(config('subscription.job_makepaid.price')*100);
        $expiry=Carbon::now()->addSeconds(config('subscription.job_makepaid.time_frame'));

        if ( $charged ) {

            $update_job=Job::find($job_id);
            $update_job->paid=1;
            $update_job->paid_expiry=$expiry;
            $update_job->save();

            $array['type'] = 'Paid Job';
            $array['heading']='Status of :'.$update_job->title;
            $array['event'] = 'updated';
            $name = $this->userLogs->getActivityDescriptionForEvent($array);
            Activity::log($name);
            return redirect()
                ->route('admin.employer.settings.makepaid')
                ->withFlashSuccess('The Selected Job successfully became paid .');
        }

        return redirect()
            ->route('admin.employer.settings.makepaid')
            ->withErrors('We were unable to charge your credit card, please try again later');
    }

/**************************************************************************************************************/
}
