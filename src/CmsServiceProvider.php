<?php

namespace Aldwyn\Blogcms;

use Illuminate\Support\ServiceProvider;

class CmsServiceProvider extends ServiceProvider
{
    protected $commands = [
        \Aldwyn\Blogcms\app\Console\Commands\AddSidebarContent::class
    ];
    /**
    * Bootstrap the application services.
    *
    * @return void
    */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadMigrationsFrom(__DIR__.'/migrations');
//        $this->loadViewsFrom(__DIR__.'/views', 'todolist');
//        $this->publishes([
//            __DIR__.'/views' => base_path('resources/views/wisdmlabs/todolist'),
//        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
//        $this->app->make('Aldwyn\Blogcms\CmsController');
    }
}
