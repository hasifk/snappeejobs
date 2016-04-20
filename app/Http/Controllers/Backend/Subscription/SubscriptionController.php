<?php  namespace App\Http\Controllers\Backend\Subscription;

use App\Http\Requests\Backend\EmployerUpgradePlanRequest;
use App\Models\Access\User\User;
use App\Repositories\Backend\Logs\LogsActivitysRepository;
use Illuminate\Http\Request;

use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Activity;

class SubscriptionController extends Controller
{

    private $userLogs;

    public function __construct(LogsActivitysRepository $userLogs) {

        $this->userLogs = $userLogs;
    }
    public function index()
    {

        $subscribed_employers = \DB::table('employer_plan')
            ->join('users', 'users.id', '=', 'employer_plan.employer_id')
            /*->whereNull('users.subscription_ends_at')
            ->orWhere('users.subscription_ends_at', '>', Carbon::now()->toDateTimeString() )*/
            ->paginate(20);

        return view('backend.subscription.index',['subscribed_employers' => $subscribed_employers]);

    }

    public function chooseplanupgrade(Requests\Backend\Employer\Settings\EmployerChooseUpgradePlanRequest $request,$userId)
    {

        $planDetails = config('subscription.employer_plans.' . User::find($userId)->EmployerSubscriptionPlan);

        $plans = config('subscription.employer_plans');

        return view('backend.subscription.chooseupgrade', [
            'subscription_plan' => $planDetails,
            'plans'=> $plans,
            'userId'=> $userId
        ]);

    }

    public function upgradeplan(EmployerUpgradePlanRequest $request, $userId)
    {

        User::find($userId)->subscription($request->get('plan_id'))->swap();

            $user=User::find($userId);
            $array['type'] = 'Plan';
            $array['heading']='With user name:'.$user->name;
            $array['event'] = 'updated';

            $name = $this->userLogs->getActivityDescriptionForEvent($array);
            Activity::log($name);


        return redirect()
            ->route('backend.subscription')
            ->withFlashSuccess('You have successfully upgraded your subscription plan. ');

    }

}
