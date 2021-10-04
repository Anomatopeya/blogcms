<?php

namespace Aldwyn\Blogcms;

use Illuminate\Support\ServiceProvider;

class CmsServiceProvider extends ServiceProvider
{
    protected $commands = [
        \Aldwyn\Blogcms\app\Console\Commands\AddSidebarContent::class,
        \Aldwyn\Blogcms\app\Console\Commands\PublishCrud::class,
        \Aldwyn\Blogcms\app\Console\Commands\AddCustomRoute::class
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

        // Публикация Файлов Админ
        $this->publishes([
            __DIR__.'/app/Http/Controllers/AdminPublishes' => app_path('Http/Controllers/Admin')
        ], 'adminCrud');
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
        // register the artisan commands
        $this->commands($this->commands);

//        $this->app->make('Aldwyn\Blogcms\CmsController');
    }
}
