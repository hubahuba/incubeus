<?php

class CategoriesTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('categories')->delete();
        
		\DB::table('categories')->insert(array (
			0 => 
			array (
				'id' => 1,
				'name' => 'Uncategories',
				'slug' => 'uncategories',
				'icon' => NULL,
				'description' => NULL,
				'creator' => 1,
				'created_at' => '2015-01-15 17:31:52',
				'updated_at' => '2015-01-15 17:31:52',
			),
		));
	}

}
