<?php
namespace CodexShaper\Permission\Commands;

use CodexShaper\Permission\PermissionServiceProvider;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Process\Process;

class InstallPermission extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
     protected $name = 'permission:install';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the CodexShaper Laravel permission';

    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Force the operation to run when in production', null],
        ];
    }
    /**
     * Get the composer command for the environment.
     *
     * @return string
     */
    protected function findComposer()
    {
        if (file_exists(getcwd().'/composer.phar')) {
            return '"'.PHP_BINARY.'" '.getcwd().'/composer.phar';
        }
        return 'composer';
    }

    public function handle()
    {
        $this->info('Publishing the Voyager assets, database, and config files');
        // Publish only relevant resources on install
        $tags = ['permission.seeds','permission.config'];
        $this->call('vendor:publish', ['--provider' => PermissionServiceProvider::class, '--tag' => $tags]);
        
        $this->info('Migrating the database tables into your application');
        $this->call('migrate', ['--force' => $this->option('force')]);


        $this->info('Dumping the autoloaded files and reloading all new files');
        $composer = $this->findComposer();
        $process = new Process($composer.' dump-autoload');
        $process->setTimeout(null); // Setting timeout to null to prevent installation from stopping at a certain point in time
        $process->setWorkingDirectory(base_path())->run();


        $this->info('Seeding data into the database');
        $this->call('db:seed', ['--class' => 'PermissionDatabaseSeeder']);
    }
}