<?php

class NccmsSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('PostsTableSeeder');
		$this->call('CategoriesTableSeeder');
		$this->call('PostCategoryTableSeeder');
	}

}
