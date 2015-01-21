<?php namespace Ngungut\Nccms;

use Illuminate\Console\Command;
use Ngungut\Nccms\Libraries\Common;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Ngungut\Nccms\PluginManager;

class InstallPlugin extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'plugin:up';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Install all nccms plugin database.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
        //running migration command
        $this->info('Install Plugin Migration.');
        $pluginManager = PluginManager::instance();
        foreach($pluginManager->getVendorAndPluginNames() as $vendor => $plugins){
            foreach($plugins as $plugin => $path){
                $migrationPath = 'nccms/plugins/' . $vendor . '/' . $plugin . '/migrations';
                $this->info('Migrating Plugin ' . $plugin);
                $this->call('migrate', ['--path' => $migrationPath, '--force' => true]);
            }
        }
	}

}
