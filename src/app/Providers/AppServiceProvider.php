<?php

namespace App\Providers;

use App\Admin\FormFields\PromocodeFieldHandler;
use Illuminate\Support\ServiceProvider;

use TCG\Voyager\Facades\Voyager as VoyagerFacade;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        VoyagerFacade::addFormField(PromocodeFieldHandler::class);
    }
}
