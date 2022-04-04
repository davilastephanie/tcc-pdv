<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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
        if (env('APP_DEBUG')) {
            DB::enableQueryLog();
        }

        Schema::defaultStringLength(190);

        Blade::include('includes.invalid-feedback', 'invalidFeedback');
        Blade::include('includes.is-invalid', 'isInvalid');
        Blade::include('includes.select-option', 'selectOption');
        Blade::include('includes.link-orderby', 'linkOrderby');
        Blade::include('includes.paginate', 'paginate');
        Blade::include('includes.url-back', 'urlBack');
        Blade::include('includes.upload-image', 'uploadImage');
    }
}
