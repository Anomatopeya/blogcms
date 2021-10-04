<?php

namespace Aldwyn\Blogcms;

use Illuminate\Support\ServiceProvider;

class CmsServiceProvider extends ServiceProvider
{
    protected $commands = [
        \Aldwyn\Blogcms\app\Console\Commands\AddSidebarContent::class,
        \Aldwyn\Blogcms\app\Console\Commands\PublishCrud::class,
        \Aldwyn\Blogcms\app\Console\Commands\AddCustomRouteContent::class
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

        // Публикация Вью Файлов Админ
        $this->publishes([
            __DIR__.'resources/views' => app_path('resources/views/vendor/backpack')
        ], 'cmsCustomView');
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
