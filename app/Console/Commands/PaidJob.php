<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use DB;

class PaidJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'snappeejobs:paidjob';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset paid status of jobs';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        DB::table('jobs')->where('paid_expiry','<',Carbon::now())->update(['paid' => 0]);
    }
}
