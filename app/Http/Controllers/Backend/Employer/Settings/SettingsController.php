<?php

namespace App\Http\Controllers\Backend\Employer\Settings;

use App\Http\Requests\Backend\Employer\Staff\EmployerChoosePlanRequest;
use App\Models\Access\User\User;
use App\Repositories\Backend\Employer\EloquentStaffRepository;
use App\Repositories\Backend\Permission\PermissionRepositoryContract;
use App\Repositories\Backend\Role\RoleRepositoryContract;
use Carbon\Carbon;
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

            return redirect()
                ->route('admin.employer.settings.usage')
                ->withFlashSuccess('You have successfully purchased the add on pack.');

        }

        return redirect()
            ->route('admin.employer.settings.usage')
            ->withErrors('Unable to charge your credit card, please try again. ');

    }

}
