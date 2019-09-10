<?php
namespace CodexShaper\Permission\Commands;

use CodexShaper\Permission\PermissionServiceProvider;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Process\Process;
use Illuminate\Filesystem\Filesystem;

class InstallPermissionDemo extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
     protected $name = 'permission:install:demo';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the CodexShaper Laravel permission Demo';

    protected $routesPath = __DIR__.'/../../routes/';

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
        $this->info('Dumping the autoloaded files and reloading all new files');
        $composer = $this->findComposer();
        $process = new Process($composer.' dump-autoload');
        $process->setTimeout(null); // Setting timeout to null to prevent installation from stopping at a certain point in time
        $process->setWorkingDirectory(base_path())->run();

        $this->info('Adding Demo Routes and resources');
        $demo_routes = $this->routesPath.'demo.php';
        $original_routes = $this->routesPath.'permission.php';
        if( file_exists($original_routes) && file_exists( $demo_routes ) ) {
            $original_contents = $filesystem->get($original_routes);
            $demo_contents = $filesystem->get($demo_routes);
            if (false === strpos($original_contents, '/* Demo Routes */')) {
                $filesystem->append(
                    $original_routes,
                    "\n\n".$demo_contents."\n"
                );
            }
        }

        $this->info('Publishing resources');
        $this->call('vendor:publish', ['--provider' => PermissionServiceProvider::class, '--tag' => ['permission.resources']]);
    }
}