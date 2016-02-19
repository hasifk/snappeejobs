<?php

namespace App\Providers;

use App\Http\ViewComposers\Backend\JobComposer;
use App\Http\ViewComposers\Backend\MailComposer;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(['backend.includes.header', 'backend.includes.sidebar'], MailComposer::class );
        view()->composer(['backend.includes.header', 'backend.includes.sidebar'], JobComposer::class );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
