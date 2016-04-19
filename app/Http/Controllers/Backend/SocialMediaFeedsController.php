<?php namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use App\Http\Requests\Backend\Employer\SocialFeeds\TwitterInfoRequest;
use App\Repositories\Backend\Dashboard\DashboardRepository;
use App\Repositories\Backend\Logs\LogsActivitysRepository;
use App\Repositories\Backend\SocialFeeds\SocialFeedsRepository;
use \Illuminate\Http\Request;
use DB;
use Activity;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class SocialMediaFeedsController extends Controller {
    /**
     * @var DashboardRepository
     */
    private $repository;
    private $userLogs;
    private $socialRepository;
    /**
     * DashboardController constructor.
     * @param DashboardRepository $repository
     */
    public function __construct(SocialFeedsRepository $socialRepository,LogsActivitysRepository $userLogs)
    {

        $this->socialRepository = $socialRepository;
        $this->userLogs = $userLogs;
    }

    /**
     * @return \Illuminate\View\View
     */



    public function twitterfeeds(Request $request)
    {
        if ( access()->hasRole('Employer') ) {
            $tweets=$this->socialRepository->getTweets();
            $view = [
                'tweets'              => $tweets,
            ];
            return view('backend.socialmediafeeds.twitterfeeds',$view);

        }
    }
    /************************************************************************************************************/
    public function addtwitterinfo(Request $request)
    {
        if ( access()->hasRole('Employer') ) {
            $screenname=$this->socialRepository->getTwScreenName();
            $view = [
                'screenname'              =>$screenname,
            ];
            return view('backend.socialmediafeeds.addtwitterinfo',$view);

        }
    }
    /************************************************************************************************************/
    public function storetwitterinfo(TwitterInfoRequest $request)
    {
        if ( access()->hasRole('Employer') ) {
            $screenname=$this->socialRepository->getTwScreenName();
            if(!empty($screenname)):
            if($tw_screenname=$this->socialRepository->updateTwScreenname($request->tw_screen_name)):
                $array['type'] = 'TwitterInfo';
                $array['heading']='of:'.auth()->user()->name;
                $array['event'] = 'updated';
                $name = $this->userLogs->getActivityDescriptionForEvent($array);
                Activity::log($name);
                $request->session()->flash('tw_success', $tw_screenname);
            else:
                $request->session()->flash('tw_failure','Failed to Update Twitter Screenname.Please try again. ') ;
            endif;
            else:
                if($tw_screenname=$this->socialRepository->storeTwScreenname($request->tw_screen_name)):
                    $array['type'] = 'TwitterInfo';
                    $array['heading']=':'.auth()->user()->name;
                    $array['event'] = 'created';
                    $name = $this->userLogs->getActivityDescriptionForEvent($array);
                    Activity::log($name);
                    $request->session()->flash('tw_success', $tw_screenname);
                else:
                    $request->session()->flash('tw_failure','Failed to Store Twitter Screenname.Please try again. ') ;
                endif;
            endif;
            return back();

        }
    }
    /************************************************************************************************************/





}
