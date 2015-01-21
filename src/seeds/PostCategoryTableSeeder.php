<?php

class PostCategoryTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('post_category')->delete();
        
		\DB::table('post_category')->insert(array (
			0 => 
			array (
				'id' => 4,
				'post_id' => 2,
				'category_id' => 1,
				'created_at' => '2015-01-15 18:15:51',
				'updated_at' => '2015-01-15 18:15:51',
			),
		));
	}

}
