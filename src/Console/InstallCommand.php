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
use Illuminate\Support\Arr;
use Moawiaab\LaravelTheme\Services\FileService;

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
        //, 'vuetify', 'api'
        if (!in_array($this->argument('stack'), ['quasar', 'vuetify', 'api'])) {
            $this->components->error('Invalid stack. Supported stacks are [quasar] , [vuetify] and [api].');

            return 1;
        }

        // Publish...
        $this->callSilent('vendor:publish', ['--tag' => 'theme-migrations', '--force' => true]);


        // set Middleware classes
        // $this->installMiddleware(['\Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class']);
        $this->installMiddleware([
            '\Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class',
        ], 'api');
        // $this->installMiddleware([
        //     '\Moawiaab\LaravelTheme\Http\Middleware\AuthGates::class',
        // ], 'api');

        if ($this->argument('stack') === 'vuetify' || $this->argument('stack') === 'quasar') {
            $this->runCommands(['composer require laravel/ui','php artisan ui vue --auth ', 'php artisan install:api', 'artisan config:publish cors']);
            $this->updateNodePackages(function ($packages) {
                return [
                    "@types/node" => "*",
                    "@vitejs/plugin-vue" => "*",
                    "@vue/tsconfig" => "*",
                    "typescript" => "*",
                    "vue-tsc" => "*",
                    "autoprefixer" => "*",
                    'sass' => "*",
                    'vue'  => '*',
                    "vite" => "*",
                ] + $packages;
            });

            $this->updateNodePackages(function ($packages) {
                return [
                    "pinia" => "*",
                    "pinia-plugin-persistedstate" => "*",
                    "vue-chartjs" => "*",
                    "nanoid" => "*",
                    "chart.js" => "*",
                    "lodash" => "^*",
                    "vue-router" => "*",
                    "vue-i18n" => "*"
                ] + $packages;
            }, false);


            (new Filesystem)->copy(__DIR__ . '/../../stubs/tsconfig.config.json', resource_path('tsconfig.config.json'));
            (new Filesystem)->copy(__DIR__ . '/../../stubs/tsconfig.json', resource_path('tsconfig.json'));

            // (new Filesystem)->copyDirectory(__DIR__ . '/../Http/Requests', app_path('Http/Requests'));
            // (new Filesystem)->copyDirectory(__DIR__ . '/../Http/Controllers/Api', app_path('Http/Controllers/Api'));

            (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/views', resource_path('views'));

            // copy(__DIR__ . '/../Providers/RouteServiceProvider.php', app_path('Providers/RouteServiceProvider.php'));
            copy(__DIR__ . '/../../routes/api.php', base_path('routes/api.php'));
            copy(__DIR__ . '/../../routes/web.php', base_path('routes/web.php'));


            (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/public', base_path('public'));
            // (new Filesystem)->copy(__DIR__ . '/../../stubs/public/Khalid-Art-Bold.ttf', base_path('public/Khalid-Art-Bold.ttf'));
            FileService::deleteAllFiles(resource_path('sass'));
            FileService::deleteAllFiles(resource_path('js'));
        }elseif( $this->argument('stack') === 'api'){
            $this->runCommands(['composer require laravel/breeze','php artisan breeze:install api']);
            copy(__DIR__ . '/../../routes/api.php', base_path('routes/api.php'));
            // copy(__DIR__ . '/../../routes/web.php', base_path('routes/web.php'));
        }



        // if ($this->option('expanse')) {
        // if (file_exists(database_path('seeders/PermissionSeeder.php'))) {
        //     $this->replaceInFile('//expanse', '', database_path('seeders/PermissionSeeder.php'));
        //     $this->replaceInFile('//locker', '', database_path('seeders/PermissionSeeder.php'));
        // } else {
        //     $this->replaceInFile('//expanse', '', database_path(__DIR__ . '/../../database/seeders/PermissionSeeder.php'));
        //     $this->replaceInFile('//locker', '', database_path(__DIR__ . '/../../database/seeders/PermissionSeeder.php'));
        // }
        $this->replaceInFile('//expanse', '', base_path('routes/api.php'));
        $this->replaceInFile('//locker', '', base_path('routes/api.php'));
        // }

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
    }

    /**
     * Install the Api stack into the application.
     *
     * @return bool
     */
    protected function installVuetifyStack()
    {
        FileService::replaceInFile('quasar', 'vuetify',  __DIR__ . '/../../config/theme.php');
        if (file_exists(base_path('postcss.config.js'))) {
            unlink(base_path('postcss.config.js'));
        }

        if (file_exists(base_path('vite.config.js'))) {
            unlink(base_path('vite.config.js'));
        }

        if (file_exists(base_path('postcss.config.cjs'))) {
            unlink(base_path('postcss.config.cjs'));
        }
        copy(__DIR__ . '/../../stubs/vuetify/vite.config.js', base_path('vite.config.js'));

        (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/vuetify/resources/sass', resource_path('sass'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/vuetify/resources/js', resource_path('js'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../../stubs/vuetify/resources/css', resource_path('css'));

        $this->updateNodePackages(function ($packages) {
            return [
                "vite-plugin-vuetify" => "^2.0.3",
                "vuetify" => "^3.6.7",
                "vue3-easy-data-table"  => "^1.5.47",
                "@mdi/font" => "^7.4.47",
                "@casl/ability" => "^6.7.1",
                "splitpanes" => "^3.1.5",
                "@casl/vue" => "^2.2.2",
                "xlsx" => "^0.18.5",
                "vue-fullscreen" => "^2.6.1",
                "@vueuse/components" => "^10.9.0",
                "@vueuse/core" => "^10.9.0"
            ] + $packages;
        }, false);


        // if ($this->option('lang')) {
        //     $this->replaceInFile('"en-US";', '"ar";', resource_path('js/app.ts'));
        //     $this->replaceInFile('rtl: false', 'rtl: true', resource_path('js/app.js'));
        // }

        if (file_exists(base_path('pnpm-lock.yaml'))) {
            $this->runCommands(['pnpm install', 'pnpm run build']);
        } elseif (file_exists(base_path('yarn.lock'))) {
            $this->runCommands(['yarn install', 'yarn run build']);
        } else {
            $this->runCommands(['npm install --force', 'npm update --force', 'npm run build']);
        }

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
        FileService::replaceInFile('vuetify', 'quasar', __DIR__ . '/../../config/theme.php');
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
                "@quasar/vite-plugin" => "*",
                "postcss-rtlcss" => "*"
            ] + $packages;
        });

        $this->updateNodePackages(function ($packages) {
            return [
                "@quasar/extras" => "*",
                "quasar" => "*",
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
            $this->runCommands(['npm install --force','npm update --force', 'npm run build']);
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
    protected function installMiddleware($names, $group = 'web', $modifier = 'append')
    {
        $bootstrapApp = file_get_contents(base_path('bootstrap/app.php'));

        $names = collect(Arr::wrap($names))
            ->filter(fn($name) => ! Str::contains($bootstrapApp, $name))
            ->whenNotEmpty(function ($names) use ($bootstrapApp, $group, $modifier) {
                $names = $names->map(fn($name) => "$name")->implode(',' . PHP_EOL . '            ');

                $bootstrapApp = str_replace(
                    '->withMiddleware(function (Middleware $middleware) {',
                    '->withMiddleware(function (Middleware $middleware) {'
                        . PHP_EOL . "        \$middleware->$group($modifier: ["
                        . PHP_EOL . "            $names,"
                        . PHP_EOL . '        ]);'
                        . PHP_EOL,
                    $bootstrapApp,
                );

                file_put_contents(base_path('bootstrap/app.php'), $bootstrapApp);
            });
    }


    protected function promptForMissingArgumentsUsing()
    {
        return [
            'stack' => fn() => select(
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
            ])->when(
                $input->getArgument('stack') === 'vuetify',
                fn($options) => $options->put('dark', 'Dark mode')
            )->when(
                $input->getArgument('stack') === 'quasar',
                fn($options) => $options->put('lang', 'Select Arabic language')
            )->sort()->sort()->all(),
        ))->each(fn($option) => $input->setOption($option, true));
    }

    // public static function delTree($dir) {

    //     $files = array_diff(scandir($dir), array('.','..'));

    //      foreach ($files as $file) {

    //        (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");

    //      }

    //      return rmdir($dir);

    //    }
}
