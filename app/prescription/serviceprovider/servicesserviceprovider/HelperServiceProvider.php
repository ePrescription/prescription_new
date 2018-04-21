<?php

namespace App\prescription\serviceprovider\servicesserviceprovider;

use App\prescription\services\HelperService;
use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //dd('Inside register');
        $this->app->bind('HelperService', function($app){
            //return new HospitalService($app->make('App\Treatin\Repositories\RepoInterface\HospitalProfileInterface'));
            $helperService = new HelperService($app->make('App\prescription\repositories\repointerface\HelperInterface'));
            return $helperService;

        });
    }
}
