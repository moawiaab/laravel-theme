<?php

namespace Moawiaab\LaravelTheme;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;

class LaravelThemeServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/theme.php', 'theme');

        $this->callAfterResolving(BladeCompiler::class, function () {
            if (config('theme.stack') === 'api') {
            }
        });
    }


    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        // $this->configureRoutes();
        $this->configureCommands();

        $this->publishes([
            __DIR__ . '/../database/migrations/' => database_path('migrations'),
            __DIR__ . '/../database/seeders/' => database_path('seeders')
        ], 'theme-migrations');

        $this->publishes([
            __DIR__ . '/../database/sub/clients' => database_path('migrations'),
        ], 'theme-client');

        $this->publishes([
            __DIR__ . '/../database/sub/suppliers' => database_path('migrations'),
        ], 'theme-supplier');
        $this->publishes([
            __DIR__ . '/../database/sub/expanses' => database_path('migrations'),
        ], 'theme-expanse');
        $this->publishes([
            __DIR__ . '/../database/sub/products' => database_path('migrations'),
        ], 'theme-product');
        $this->publishes([
            __DIR__ . '/../database/sub/locker' => database_path('migrations'),
        ], 'theme-locker');

        // $this->publishes([
        //     __DIR__ . '/../database/seeders/' => database_path('seeders')
        // ], 'role-migrations');

        copy(__DIR__ . '/Models/User.php', app_path('Models/User.php'));
        copy(__DIR__ . '/../database/seeders/DatabaseSeeder.php', database_path('seeders/DatabaseSeeder.php'));


        // copy(__DIR__.'/Http/Middleware/HandleInertiaRequests.php', app_path('Http/Middleware/HandleInertiaRequests.php'));

        // if (config('role.stack') === 'inertia') {
        // }
    }

    /**
     * Configure the routes offered by the application.
     *
     * @return void
     */

    protected function configureRoutes()
    {
        Route::group(
            [
                // 'prefix' => "api",
                'namespace' => 'Moawiaab\LaravelTheme\Http\Controllers\Api',
                'middleware' => ['auth:sanctum']
            ],
            function () {
                $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
            }
        );
    }

    /**
     * Configure the commands offered by the application.
     *
     * @return void
     */
    protected function configureCommands()
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            Console\InstallCommand::class,
        ]);
    }
}
