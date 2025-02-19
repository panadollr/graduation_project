<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // if (config('app.env') == 'production') {
        //     URL::forceScheme('https');
        // }

        // DB::prohibitDestructiveCommands(
        //     $this->app->isProduction()
        // );

        Builder::macro('search', function ($field, $string) {
            return $string ? $this->where($field, 'like', '%' . $string . '%') : $this;
        });

        View::composer('client.partials.header.header', function ($view) {
            $categories = Cache::remember('categories', now()->addHours(8), function () {
                return Category::whereNull('parent_id')->select('name', 'slug')->get();
            });
            $view->with('categories', $categories);
        });
    }
}
