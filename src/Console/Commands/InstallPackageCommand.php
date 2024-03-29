<?php

namespace Ladmin\Engine\Console\Commands;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\Console\Input\InputOption;

class InstallPackageCommand extends Command
{


    protected $option = 'Modules\\';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ladmin:install
                            {--and= : Run an other command after installation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install ladmin engine support';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $this->checkModuleFoler();

        $this->overideComposerJson();


        $this->call('vendor:publish', [
            '--tag' => 'ladmin-config',
            '--force' => true
        ]);

        $this->call('vendor:publish', [
            '--tag' => 'ladmin-database-seeder',
            '--force' => true
        ]);

        $this->call('vendor:publish', [
            '--tag' => 'ladmin-menu',
            '--force' => true
        ]);

        $this->call('vendor:publish', [
            '--tag' => 'ladmin-stub',
            '--force' => true
        ]);

        $this->call('vendor:publish', [
            '--tag' => 'ladmin-logo',
            '--force' => true
        ]);

        if (!$this->hasNotificationMigration()) {
            $this->call('notifications:table');
        }

        $this->runAnOtherCommand(
            $this->option('and')
        );
        
        $this->line('----------------------------------------------------');
        $this->line('');
        $this->info('php artisan migrate --seed');
        $this->line('');
        $this->info('Installation has been finished. 🏁');
        $this->line('');
        $this->line('----------------------------------------------------');
        $this->line('');

        $this->info('Please wait a moment for dump-autoload...');
        Process::path(base_path(''))->start('composer dump-autoload');
    }

    /**
     * Install other command from an other module
     *
     * @return void
     */
    protected function runAnOtherCommand($command)
    {
        if ($command) {
            try {
                $this->call($command);
            } catch (Exception $e) {
            }
        }
    }

    /**
     * Check notification migration file
     */
    protected function hasNotificationMigration()
    {
        $exists = false;
        foreach (scandir(base_path('database/migrations')) as $file) {
            if (Str::of($file)->contains('create_notifications_table')) {
                $exists = true;
            }
        }
        return $exists;
    }

    /**
     * Overide composer json
     */
    protected function overideComposerJson()
    {

        $composer = base_path('composer.json');
        $decode = json_decode(str_replace(PHP_EOL, '', file_get_contents($composer)), true);

        if (!array_key_exists($this->option, $decode['autoload']['psr-4'])) {
            $getPsr4 = $decode['autoload']['psr-4'];
            $newPsr4 = array_merge($getPsr4, [$this->option => $this->option]);
            $autoload = [
                'autoload' => [
                    'psr-4' => $newPsr4
                ]
            ];
            $merge = array_merge($decode, $autoload);
            $encode = json_encode($merge, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
            file_put_contents($composer, $encode);

            $this->info(rtrim($this->option, '\\') . ' autoload successfully added 👍');
        } else {
            $this->info('Autoload is ready 👍');
        }
    }

    /**
     * Check module exists
     */
    protected function checkModuleFoler()
    {
        $folder = base_path('Modules');
        if (!is_dir($folder)) {
            mkdir($folder);
            $this->info('Module folder has been created 👍');
        } else {
            $this->info('Module folder is ready 👍');
        }
    }


    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['command', 'c', InputOption::VALUE_OPTIONAL, 'Run an other command after installation']
        ];
    }
}
