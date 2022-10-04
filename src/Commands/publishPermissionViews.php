<?php
namespace CodexShaper\Permission\Commands;

use CodexShaper\Permission\PermissionServiceProvider;
use Illuminate\Console\Command;

class PublishPermissionViews extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
     protected $name = 'permission:publish:views';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the CodexShaper Laravel permission Resources';


    public function handle()
    {

        $this->info('Publishing Views');
        $this->call('vendor:publish', ['--provider' => PermissionServiceProvider::class, '--tag' => ['permission.views']]);
    }
}
