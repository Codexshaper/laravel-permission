<?php
namespace CodexShaper\Permission\Commands;

use CodexShaper\Permission\PermissionServiceProvider;
use Illuminate\Console\Command;

class PublishPermissionResources extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    
     protected $name = 'permission:publish:resources';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the CodexShaper Laravel permission Resources';


    public function handle()
    {

        $this->info('Publishing resources');
        $this->call('vendor:publish', ['--provider' => PermissionServiceProvider::class, '--tag' => ['permission.resources']]);
    }
}
