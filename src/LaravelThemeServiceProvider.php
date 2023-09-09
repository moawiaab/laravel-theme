<?php

namespace Moawiaab\LaravelTheme;


use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\Contracts\Http\Kernel;
use Moawiaab\LaravelTheme\Http\Middleware\AuthGates;

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
        // $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        // $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->configureCommands();

        $this->publishes([
            __DIR__ . '/../database/migrations/' => database_path('migrations')
        ], 'role-migrations');

        $this->publishes([
            __DIR__ . '/../database/seeders/' => database_path('seeders')
        ], 'role-migrations');

        copy(__DIR__ . '/Models/User.php', app_path('Models/User.php'));
        copy(__DIR__ . '/../database/seeders/DatabaseSeeder.php', database_path('seeders/DatabaseSeeder.php'));

        
        // copy(__DIR__.'/Http/Middleware/HandleInertiaRequests.php', app_path('Http/Middleware/HandleInertiaRequests.php'));

        // if (config('role.stack') === 'inertia') {
        // }
        $this->bootInertia();
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

    /**
     * Boot any Inertia related services.
     *
     * @return void
     */
    protected function bootInertia()
    {
        $kernel = $this->app->make(Kernel::class);

        $kernel->appendMiddlewareToGroup('web', AuthGates::class);
        $kernel->appendMiddlewareToGroup('api', AuthGates::class);
        $kernel->appendToMiddlewarePriority(AuthGates::class);

        // if (class_exists(HandleInertiaRequests::class)) {
        //     $kernel->appendToMiddlewarePriority(HandleInertiaRequests::class);
        // }

    }
}
