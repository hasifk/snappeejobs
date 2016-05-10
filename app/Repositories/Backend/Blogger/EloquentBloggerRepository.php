<?php namespace App\Repositories\Backend\Blogger;


use App\Models\Company\SocialFeeds\SocialMediaFeeds;
use Twitter;

/**
 * Class EloquentUserRepository
 * @package App\Repositories\User
 */
class EloquentBloggerRepository {


    public function getBloggers($name)
    {

        $store_tw_screenname=new SocialMediaFeeds();
        $store_tw_screenname->user_id=auth()->user()->id;
        $store_tw_screenname->tw_screen_name=$name;
        $store_tw_screenname->save();
        return "Twitter Screenname Saved Successfully";



    }
    /*********************************************************************************************************/
    public function updateTwScreenname($name)
    {

        SocialMediaFeeds::where('user_id',auth()->user()->id)->update(['tw_screen_name' => $name]);
        return "Twitter Screenname Successfully Updated";



    }
    /*********************************************************************************************************/
    public function getTweets()
    {

        $screen_name=SocialMediaFeeds::where('user_id',auth()->user()->id)->pluck('tw_screen_name');
        if(!empty($screen_name)):
            try {
                $tweets = Twitter::getUserTimeline(array('screen_name' => $screen_name, 'count' => 20));
            }
            catch(\Exception $e)
            {
                $tweets='';
            }
        else:
            $tweets='';
        endif;
        return $tweets;



    }
    /*********************************************************************************************************/
    public function getTwScreenname()
    {
        $screen_name='';
        $screen_name=SocialMediaFeeds::where('user_id',auth()->user()->id)->pluck('tw_screen_name');
        return $screen_name;



    }
    /*********************************************************************************************************/



}
