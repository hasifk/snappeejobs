<?php  namespace App\Http\Controllers\Backend\Subscription;

use Illuminate\Http\Request;

use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class SubscriptionController extends Controller
{
    public function index()
    {

        $subscribed_employers = \DB::table('employer_plan')
            ->join('users', 'users.id', '=', 'employer_plan.employer_id')
            /*->whereNull('users.subscription_ends_at')
            ->orWhere('users.subscription_ends_at', '>', Carbon::now()->toDateTimeString() )*/
            ->paginate(20);

        return view('backend.subscription.index',['subscribed_employers' => $subscribed_employers]);

    }
}
