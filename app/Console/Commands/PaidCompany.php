<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use DB;
class PaidCompany extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'snappeejobs:paidcompany';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset paid status of companies';

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
        //
        DB::table('companies')->where('paid_expiry','<',Carbon::now())->update(['paid' => 0]);
    }
}
