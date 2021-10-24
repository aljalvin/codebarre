<?php

namespace philouAP\CodeBarre;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class CodeBarreProvider extends ServiceProvider
{

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/codebarre.php' => config_path('codebarre.php'),
        ]);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('CODEBARRE', function() {
            return new CODEBARRE;
        });
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {
        return array("CODEBARRE");
    }


}
