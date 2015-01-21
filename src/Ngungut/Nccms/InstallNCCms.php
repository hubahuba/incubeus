<?php namespace Ngungut\Nccms;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class InstallNCCms extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'nccms:install';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Install all nccms database, asset, folder needed.';

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
        //create plugins folder
        if(!is_dir(base_path() . '/nccms/plugins')){
            $this->info('Creating Plugins Folder.');
            if(!is_dir(base_path() . '/nccms')){
                mkdir(base_path() . '/nccms');
            }
            mkdir(base_path() . '/nccms/plugins');
        }
        if(!is_dir(base_path() . '/nccms/partials')){
            $this->info('Creating Partial Folder.');
            if(!is_dir(base_path() . '/nccms')){
                mkdir(base_path() . '/nccms');
            }
            File::copyDirectory(__DIR__ . '/../../partials', base_path() . '/nccms');
        }
        if(!is_dir(public_path() . '/uploads')){
            $this->info('Creating Upload Folder.');
            mkdir(public_path() . '/uploads');
        }
        //running migration command
        $this->info('Install Database Migration.');
        $this->call('migrate', ['--package' => 'ngungut/nccms', '--force' => true]);
        //running seeding db
        $this->info('Start Seed Database.');
        $this->call('db:seed', ['--class' => 'NccmsSeeder', '--force' => true]);
        //publishing asset
        $this->info('Publishing Asset.');
        $this->call('asset:publish', ['package' => 'ngungut/nccms']);
        //publishing config
        $this->info('Copying Config.');
        $this->call('config:publish', ['package' => 'ngungut/nccms']);
	}

}
