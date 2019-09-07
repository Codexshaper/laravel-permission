<?php
namespace CodexShaper\Permission\Commands;

use CodexShaper\Permission\PermissionServiceProvider;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Process\Process;
use Illuminate\Filesystem\Filesystem;

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
            ['with-dummy', null, InputOption::VALUE_NONE, 'Install with dummy data', null],
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
    // public function fire(Filesystem $filesystem)
    // {
    //     return $this->handle($filesystem);
    // }
    /**
     * Execute the console command.
     *
     * @param \Illuminate\Filesystem\Filesystem $filesystem
     *
     * @return void
     */
    public function handle( Filesystem $filesystem)
    {
        $this->info('Publishing the Voyager assets, database, and config files');
        // Publish only relevant resources on install
        $tags = ['permission.seeds','permission.config'];
        $this->call('vendor:publish', ['--provider' => PermissionServiceProvider::class, '--tag' => $tags]);
        
        $this->info('Migrating the database tables into your application');
        $this->call('migrate', ['--force' => $this->option('force')]);

        // $this->info('Attempting to set Permission User model as parent to App\User');
        // if (file_exists(app_path('User.php'))) {
        //     $str = file_get_contents(app_path('User.php'));
        //     if ($str !== false) {
        //         $str = str_replace('extends Authenticatable', "extends \CodexShaper\Permission\Models\User", $str);
        //         file_put_contents(app_path('User.php'), $str);
        //     }
        // } else {
        //     $this->warn('Unable to locate "app/User.php".  Did you move this file?');
        //     $this->warn('You will need to update this manually. "use HasRoles" in your User model');
        // }

        $this->info('Dumping the autoloaded files and reloading all new files');
        $composer = $this->findComposer();
        $process = new Process($composer.' dump-autoload');
        $process->setTimeout(null); // Setting timeout to null to prevent installation from stopping at a certain point in time
        $process->setWorkingDirectory(base_path())->run();

        // Load Permission routes into application's 'routes/web.php'

        $this->info('Adding Permission routes to routes/web.php');
        $routes_contents = $filesystem->get(base_path('routes/web.php'));
        if (false === strpos($routes_contents, 'Permission::routes()')) {
            $filesystem->append(
                base_path('routes/web.php'),
                "\n\nRoute::group(['prefix' => config('permission.prefix')], function () {\n    Permission::routes();\n});\n"
            );
        }

        // Seeding Dummy Data

        $this->info('Seeding data into the database');

        // $class = 'PermissionDatabaseSeeder';

        // if (!class_exists($class)) {
        //     require_once $this->seedersPath.$class.'.php';
        // }
        // with(new $class())->run();

        $this->call('db:seed', ['--class' => 'PermissionDatabaseSeeder']);

        // if ($this->option('with-dummy')) {
        //     $this->info('Publishing dummy content');
        //     $tags = ['dummy_seeds', 'dummy_content', 'dummy_config', 'dummy_migrations'];
        //     $this->call('vendor:publish', ['--provider' => VoyagerDummyServiceProvider::class, '--tag' => $tags]);
        //     $this->info('Migrating dummy tables');
        //     $this->call('migrate');
        //     $this->info('Seeding dummy data');
        //     $this->seed('VoyagerDummyDatabaseSeeder');
        // } else {
        //     $this->call('vendor:publish', ['--provider' => VoyagerServiceProvider::class, '--tag' => ['config', 'voyager_avatar']]);
        // }
        // $this->info('Setting up the hooks');
        // $this->call('hook:setup');
        // $this->info('Adding the storage symlink to your public folder');
        // $this->call('storage:link');
        // $this->info('Successfully installed Voyager! Enjoy');
    }
}