<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TablePosts extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('posts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->text('template');
			$table->string('title', 254);
			$table->string('slug', 254)->unique();
			$table->text('post')->nullable();
			$table->string('excerpt', 200)->nullable();
            $table->text('feature_image')->nullable();
            $table->string('type', 4);
            $table->string('status', 3);
            $table->integer('creator')->unsigned();
            $table->foreign('creator')
                ->references('id')->on('users');
            $table->date('publish_date')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('posts');
	}

}
