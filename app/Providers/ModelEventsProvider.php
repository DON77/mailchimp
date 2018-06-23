<?php

namespace App\Providers;

use App\MainModel;
use Illuminate\Support\ServiceProvider;

class ModelEventsProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        MainModel::creating(function($model) {
            if (method_exists($model, 'afterSave')) {
                $model->afterSave();
            }
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
