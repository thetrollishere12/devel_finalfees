<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Blade;

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
        Schema::defaultStringLength(191);
        Blade::directive('dateconvert', function ($original_date) {
            return "<?php echo date('d/m/Y',strtotime($original_date));  ?>";
            });
        Blade::directive('moneyconvert', function ($number) {
        return "<?php  number_format($number, 2, '.', ',');  ?>";
        });
    }
}
