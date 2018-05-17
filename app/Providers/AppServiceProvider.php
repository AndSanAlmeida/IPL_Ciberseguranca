<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\UserQuestion;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (Schema::hasTable('user_questions')) {
            $notAnswered = UserQuestion::where('isAnswered', 0)->count();
            View::share('notAnswered', $notAnswered);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
