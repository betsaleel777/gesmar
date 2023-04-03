<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $allHelpersPerfiles = glob(app_path('Helpers') . '/*.php');
        foreach ($allHelpersPerfiles as $helperFile) {
            require_once $helperFile;
        }
    }
}
