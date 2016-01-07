<?php

namespace App\Providers;

use App\Http\ViewComposers\Backend\MailComposer;
use Illuminate\Contracts\View\View;
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
