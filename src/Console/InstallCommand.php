<?php

namespace Moawiaab\LaravelTheme\Console;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use RuntimeException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\select;

class InstallCommand extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravel-theme:install {stack : The development stack that should be installed (quasar,vuetify, api)}
                                                  {--dark : Indicate that dark mode support  be installed}
                                                  {--locker : Indicate that Treasury management mode support support be installed}
                                                  {--expanse : Indicate that expanse management mode support support be installed}
                                                  {--client : Indicate that client management mode support  be installed}
                                                  {--supplier : Indicate that supplier management mode support  be installed}
                                                  {--product : Indicate that product management mode support  be installed}
                                                  {--lang : Make Arabic the default language}
                                                  {--composer=global : Absolute path to the Composer binary which should be used to install packages}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the laravel-theme components and resources';

    /**
     * Execute the console command.
     *
     * @return int|null
     */
    public function handle()
    {
        if (!in_array($this->argument('stack'), ['quasar', 'vuetify', 'api'])) {
            $this->components->error('Invalid stack. Supported stacks are [quasar] , [vuetify] and [api].');

            return 1;
        }

        // set Middleware classes
        $this->installMiddlewareAfter('SubstituteBindings::class', '\Moawiaab\LaravelTheme\Http\Middleware\AuthGates::class');

        if ($this->argument('stack') === 'vuetify' || $this->argument('stack') === 'quasar') {
            $this->runCommands(['php artisan ui vue --auth']);
            $this->updateNodePackages(function ($packages) {
                return [
                    "@types/node" => "^20.4.7",
                    "@vitejs/plugin-vue" => "^4.2.0",
                    "@vue/tsconfig" => "^0.4.0",
                    "typescript" => "^5.1.6",
                    "vue-tsc" => "^1.8.8",
                    "autoprefixer" => "^10.4.12",
                    'sass' => "^1.66.1"
                ] + $packages;
            });

            $this->updateNodePackages(function ($packages) {
                return [
                    "pinia" => "^2.1.6",
                    "pinia-plugin-persistedstate" => "^3.2.0",
                    "vue-chartjs" => "^5.2.0",
                    "nanoid" => "^4.0.2",
                    "chart.js" => "^4.3.3",
                    "lodash" => "^4.17.21",
                    "vue-router" => "^4.2.4"
                ] + $packages;
            }, false);


            (new Filesystem)->copy(__DIR__ . '/../../stubs/tsconfig.config.json', resource_path('tsconfig.config.json'));
            (new Filesystem)->copy(__DIR__ . '/../../stubs/tsconfig.json', resource_path('tsconfig.json'));

            (new Filesystem)->copyDirectory(__DIR__ . '/../Http/Requests', app_path('Http/Requests'));
            (new Filesystem)->copyDirectory(__DIR__ . '/../Http/Controllers/Api', app_path('Http/Controllers/Api'));

            (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/quasar/resources/views', resource_path('views'));

            copy(__DIR__ . '/../Providers/RouteServiceProvider.php', app_path('Providers/RouteServiceProvider.php'));
            copy(__DIR__ . '/../../routes/api.php', base_path('routes/api.php'));
            copy(__DIR__ . '/../../routes/web.php', base_path('routes/web.php'));


            (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/public/img', base_path('public/img'));
            (new Filesystem)->copy(__DIR__ . '/../../stubs/public/Khalid-Art-Bold.ttf', base_path('public/Khalid-Art-Bold.ttf'));
        }



        if ($this->option('locker')) {
            if (file_exists(database_path('seeders/PermissionSeeder.php'))) {
                $this->replaceInFile('//locker', '', database_path('seeders/PermissionSeeder.php'));
            } else {
                $this->replaceInFile('//locker', '', database_path(__DIR__ . '/../../database/seeders/PermissionSeeder.php'));
            }
            $this->replaceInFile('//locker', '', base_path('routes/api.php'));
        }

        if ($this->option('expanse')) {
            if (file_exists(database_path('seeders/PermissionSeeder.php'))) {
                $this->replaceInFile('//expanse', '', database_path('seeders/PermissionSeeder.php'));
                $this->replaceInFile('//locker', '', database_path('seeders/PermissionSeeder.php'));
            } else {
                $this->replaceInFile('//expanse', '', database_path(__DIR__ . '/../../database/seeders/PermissionSeeder.php'));
                $this->replaceInFile('//locker', '', database_path(__DIR__ . '/../../database/seeders/PermissionSeeder.php'));
            }
            $this->replaceInFile('//expanse', '', base_path('routes/api.php'));
            $this->replaceInFile('//locker', '', base_path('routes/api.php'));
        }

        if ($this->option('client')) {
            if (file_exists(database_path('seeders/PermissionSeeder.php'))) {
                $this->replaceInFile('//client', '', database_path('seeders/PermissionSeeder.php'));
                $this->replaceInFile('//locker', '', database_path('seeders/PermissionSeeder.php'));
            } else {
                $this->replaceInFile('//client', '', database_path(__DIR__ . '/../../database/seeders/PermissionSeeder.php'));
                $this->replaceInFile('//locker', '', database_path(__DIR__ . '/../../database/seeders/PermissionSeeder.php'));
            }
            $this->replaceInFile('//client', '', base_path('routes/api.php'));
            $this->replaceInFile('//locker', '', base_path('routes/api.php'));
        }

        if ($this->option('supplier')) {
            if (file_exists(database_path('seeders/PermissionSeeder.php'))) {
                $this->replaceInFile('//supplier', '', database_path('seeders/PermissionSeeder.php'));
                $this->replaceInFile('//locker', '', database_path('seeders/PermissionSeeder.php'));
            } else {
                $this->replaceInFile('//supplier', '', database_path(__DIR__ . '/../../database/seeders/PermissionSeeder.php'));
                $this->replaceInFile('//locker', '', database_path(__DIR__ . '/../../database/seeders/PermissionSeeder.php'));
            }
            $this->replaceInFile('//supplier', '', base_path('routes/api.php'));
            $this->replaceInFile('//locker', '', base_path('routes/api.php'));
        }

        if ($this->option('product')) {
            if (file_exists(database_path('seeders/PermissionSeeder.php'))) {
                $this->replaceInFile('//client', '', database_path('seeders/PermissionSeeder.php'));
                $this->replaceInFile('//supplier', '', database_path('seeders/PermissionSeeder.php'));
                $this->replaceInFile('//locker', '', database_path('seeders/PermissionSeeder.php'));
                $this->replaceInFile('//product', '', database_path('seeders/PermissionSeeder.php'));
            } else {
                $this->replaceInFile('//client', '', database_path(__DIR__ . '/../../database/seeders/PermissionSeeder.php'));
                $this->replaceInFile('//supplier', '', database_path(__DIR__ . '/../../database/seeders/PermissionSeeder.php'));
                $this->replaceInFile('//locker', '', database_path(__DIR__ . '/../../database/seeders/PermissionSeeder.php'));
                $this->replaceInFile('//product', '', database_path(__DIR__ . '/../../database/seeders/PermissionSeeder.php'));
            }
            $this->replaceInFile('//client', '', base_path('routes/api.php'));
            $this->replaceInFile('//locker', '', base_path('routes/api.php'));
            $this->replaceInFile('//supplier', '', base_path('routes/api.php'));
            $this->replaceInFile('//product', '', base_path('routes/api.php'));
        }



                // Install Stack...
                if ($this->argument('stack') === 'vuetify') {
                    if (!$this->installVuetifyStack()) {
                        return 1;
                    }
                } elseif ($this->argument('stack') === 'quasar') {
                    if (!$this->installQuasarStack()) {
                        return 1;
                    }
                }
        // if (
        //     !$this->option('locker')
        //     && !$this->option('client')
        //     && !$this->option('supplier')
        //     && !$this->option('product')
        //     && !$this->option('expanse')
        // ) {
        //     unlink(app_path('Http/Controllers/Api/ClientApiController.php'));
        //     unlink(app_path('Http/Controllers/Api/BudgetApiController.php'));
        //     unlink(app_path('Http/Controllers/Api/BudgetNameApiController.php'));
        //     unlink(app_path('Http/Controllers/Api/CategoryApiController.php'));
        //     unlink(app_path('Http/Controllers/Api/CheckApiController.php'));
        //     unlink(app_path('Http/Controllers/Api/ExpanseApiController.php'));
        //     unlink(app_path('Http/Controllers/Api/OrderApiController.php'));
        //     unlink(app_path('Http/Controllers/Api/PrivateLockerApiController.php'));
        //     unlink(app_path('Http/Controllers/Api/ProductApiController.php'));
        //     unlink(app_path('Http/Controllers/Api/PublicTreasuryApiController.php'));
        //     unlink(app_path('Http/Controllers/Api/ReportsApiController.php'));
        //     unlink(app_path('Http/Controllers/Api/StageApiController.php'));
        //     unlink(app_path('Http/Controllers/Api/StoreApiController.php'));
        //     unlink(app_path('Http/Controllers/Api/SupplierApiController.php'));
        //     unlink(app_path('Http/Controllers/Api/SupplierOrderApiController.php'));
        //     unlink(app_path('Http/Controllers/Api/UnitApiController.php'));
        // } else {
        //     if (!$this->option('expanse')) {
        //         if (file_exists(app_path('Http/Controllers/Api/ExpanseApiController.php'))) {
        //             unlink(app_path('Http/Controllers/Api/ExpanseApiController.php'));
        //         }
        //         if (file_exists(app_path('Http/Controllers/Api/BudgetApiController.php'))) {
        //             unlink(app_path('Http/Controllers/Api/BudgetApiController.php'));
        //         }
        //         if (file_exists(app_path('Http/Controllers/Api/BudgetNameApiController.php'))) {
        //             unlink(app_path('Http/Controllers/Api/BudgetNameApiController.php'));
        //         }
        //     }
        //     if (!$this->option('client') && !$this->option('product')) {
        //         if (file_exists(app_path('Http/Controllers/Api/ClientApiController.php'))) {
        //             unlink(app_path('Http/Controllers/Api/ClientApiController.php'));
        //         }
        //     }
        //     if (!$this->option('supplier') && !$this->option('product')) {
        //         if (file_exists(app_path('Http/Controllers/Api/SupplierApiController.php'))) {
        //             unlink(app_path('Http/Controllers/Api/SupplierApiController.php'));
        //         }
        //     }
        //     if (!$this->option('product')) {
        //         if (file_exists(app_path('Http/Controllers/Api/CategoryApiController.php'))) {
        //             unlink(app_path('Http/Controllers/Api/CategoryApiController.php'));
        //         }
        //         if (file_exists(app_path('Http/Controllers/Api/OrderApiController.php'))) {
        //             unlink(app_path('Http/Controllers/Api/OrderApiController.php'));
        //         }
        //         if (file_exists(app_path('Http/Controllers/Api/ProductApiController.php'))) {
        //             unlink(app_path('Http/Controllers/Api/ProductApiController.php'));
        //         }

        //         if (file_exists(app_path('Http/Controllers/Api/StoreApiController.php'))) {
        //             unlink(app_path('Http/Controllers/Api/StoreApiController.php'));
        //         }
        //         if (file_exists(app_path('Http/Controllers/Api/UnitApiController.php'))) {
        //             unlink(app_path('Http/Controllers/Api/UnitApiController.php'));
        //         }
        //         if (file_exists(app_path('Http/Controllers/Api/SupplierOrderApiController.php'))) {
        //             unlink(app_path('Http/Controllers/Api/SupplierOrderApiController.php'));
        //         }
        //     }
        // }
    }

    /**
     * Install the Api stack into the application.
     *
     * @return bool
     */
    protected function installVuetifyStack()
    {
        // Terms Of Service / Privacy Policy...

        $this->line('');
        $this->components->info('vuetify theme installed successfully.');

        return true;
    }


    /**
     * Install the Inertia stack into the application.
     *
     * @return bool
     */
    protected function installQuasarStack()
    {
        if (file_exists(base_path('postcss.config.js'))) {
            unlink(base_path('postcss.config.js'));
        }

        if (file_exists(base_path('vite.config.js'))) {
            unlink(base_path('vite.config.js'));
        }
        copy(__DIR__ . '/../../stubs/quasar/postcss.config.cjs', base_path('postcss.config.cjs'));
        copy(__DIR__ . '/../../stubs/quasar/vite.config.js', base_path('vite.config.js'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/quasar/resources/sass', resource_path('sass'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/quasar/resources/js', resource_path('js'));

        $this->updateNodePackages(function ($packages) {
            return [
                "@quasar/vite-plugin" => "^1.4.1",
                "postcss-rtlcss" => "^4.0.7"
            ] + $packages;
        });

        $this->updateNodePackages(function ($packages) {
            return [
                "@quasar/extras" => "^1.16.6",
                "quasar" => "^2.12.5",
                "vue-i18n" => "^9.3.0-beta.25"
            ] + $packages;
        }, false);


        if ($this->option('lang')) {
            $this->replaceInFile('"en-US";', '"ar";', resource_path('js/app.ts'));
            $this->replaceInFile('rtl: false', 'rtl: true', resource_path('js/app.js'));
        }

        if (file_exists(base_path('pnpm-lock.yaml'))) {
            $this->runCommands(['pnpm install', 'pnpm run build']);
        } elseif (file_exists(base_path('yarn.lock'))) {
            $this->runCommands(['yarn install', 'yarn run build']);
        } else {
            $this->runCommands(['npm install --force', 'npm run build']);
        }


        $this->line('');
        $this->components->info('quasar theme installed successfully.');

        return true;
    }

    /**
     * Update the "package.json" file.
     *
     * @param  callable  $callback
     * @param  bool  $dev
     * @return void
     */
    protected static function updateNodePackages(callable $callback, $dev = true)
    {
        if (!file_exists(base_path('package.json'))) {
            return;
        }

        $configurationKey = $dev ? 'devDependencies' : 'dependencies';

        $packages = json_decode(file_get_contents(base_path('package.json')), true);

        $packages[$configurationKey] = $callback(
            array_key_exists($configurationKey, $packages) ? $packages[$configurationKey] : [],
            $configurationKey
        );

        ksort($packages[$configurationKey]);

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . PHP_EOL
        );
    }

    /**
     * Replace a given string within a given file.
     *
     * @param  string  $search
     * @param  string  $replace
     * @param  string  $path
     * @return void
     */
    protected function replaceInFile($search, $replace, $path)
    {
        file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
    }

    /**
     * Run the given commands.
     *
     * @param  array  $commands
     * @return void
     */
    protected function runCommands($commands)
    {
        $process = Process::fromShellCommandline(implode(' && ', $commands), null, null, null, null);

        if ('\\' !== DIRECTORY_SEPARATOR && file_exists('/dev/tty') && is_readable('/dev/tty')) {
            try {
                $process->setTty(true);
            } catch (RuntimeException $e) {
                $this->output->writeln('  <bg=yellow;fg=black> WARN </> ' . $e->getMessage() . PHP_EOL);
            }
        }

        $process->run(function ($type, $line) {
            $this->output->write('    ' . $line);
        });
    }

    protected function installMiddlewareAfter($after, $name, $group = 'web')
    {
        $httpKernel = file_get_contents(app_path('Http/Kernel.php'));

        $middlewareGroups = Str::before(Str::after($httpKernel, '$middlewareGroups = ['), '];');
        $middlewareGroup = Str::before(Str::after($middlewareGroups, "'$group' => ["), '],');

        if (!Str::contains($middlewareGroup, $name)) {
            $modifiedMiddlewareGroup = str_replace(
                $after . ',',
                $after . ',' . PHP_EOL . '            ' . $name . ',',
                $middlewareGroup,
            );

            file_put_contents(app_path('Http/Kernel.php'), str_replace(
                $middlewareGroups,
                str_replace($middlewareGroup, $modifiedMiddlewareGroup, $middlewareGroups),
                $httpKernel
            ));
        }
    }


    protected function promptForMissingArgumentsUsing()
    {
        return [
            'stack' => fn () => select(
                label: 'Which laravel-theme theme would you like to install?',
                options: [
                    'quasar' => 'quasar',
                    'vuetify' => 'vuetify',
                    'api'     => 'api only'
                ]
            ),
        ];
    }

    /**
     * Interact further with the user if they were prompted for missing arguments.
     *
     * @param  \Symfony\Component\Console\Input\InputInterface  $input
     * @param  \Symfony\Component\Console\Output\OutputInterface  $output
     * @return void
     */
    protected function afterPromptingForMissingArguments(InputInterface $input, OutputInterface $output)
    {
        collect(multiselect(
            label: 'Would you like any optional features?',
            options: collect([
                'locker' => 'Treasury management',
                'expanse' => 'Expenses and budget',
                'client' => 'Customer management',
                'supplier' => 'Supplier management',
                'product' => 'Product management',
            ])->when(
                $input->getArgument('stack') === 'vuetify',
                fn ($options) => $options->put('dark', 'Dark mode')
            )->when(
                $input->getArgument('stack') === 'quasar',
                fn ($options) => $options->put('lang', 'Select Arabic language')
            )->sort()->sort()->all(),
        ))->each(fn ($option) => $input->setOption($option, true));

        // $input->setOption('pest', select(
        //     label: 'Which testing framework do you prefer?',
        //     options: ['PHPUnit', 'Pest'],
        //     default: 'default',
        // ) === 'Pest');
    }
}
