<?php

namespace App\Providers;

use App\Tag;
use App\Post;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer( 'layouts.sidebar', function ($view) {
            $view->with([
                'tags' => Tag::withCount('posts')->orderBy('name')->get(),
                'archives' => Post::selectRaw('year(created_at) as year, monthname(created_at) as month, count(*) as posts')
                    ->groupBy( 'year', 'month' )
                    ->orderByRaw( 'min(created_at) desc')
                    ->get(),
            ]);
        });
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
