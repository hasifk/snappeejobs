<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\Company\CompanyFollowers;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendNewJobNotifEmail extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
  protected $jobObj;

    public function __construct($jobObj)
    {
        $this->jobObj=$jobObj;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $flw_count = CompanyFollowers::count();
        if (!empty($flw_count)):
            $followers_company = CompanyFollowers::join('users', 'users.id', '=', 'follow_companies.user_id')
                ->join('companies', 'companies.id', '=', 'follow_companies.company_id')
                ->where('follow_companies.company_id', '=',  $this->jobObj->company_id)
                ->select([
                    'users.email', 'users.name',
                    'companies.url_slug',
                    \DB::raw('companies.title AS company_title')
                ])->get();
            if (!empty($followers_company)):
            foreach ($followers_company as $follower) {
                Mail::send('emails.send_job_notifs', ['username' => $follower->name, 'company' => $follower->url_slug,
                    'company_title' => $follower->company_title,'job_title' => $this->jobObj->title, 'job' => $this->jobObj->title_url_slug], function ($message) use ($follower) {
                    $message->to($follower->email, $follower->name)->subject('New Job Updates!');
                });
            }
        endif;
        endif;
    }

}
