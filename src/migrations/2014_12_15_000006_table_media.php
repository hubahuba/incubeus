<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableMedia extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('media', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('thumbnail', 128)->nullable()->unique();
            $table->string('medium', 128)->nullable()->unique();
            $table->string('large', 128)->nullable()->unique();
            $table->string('realname', 128)->nullable()->unique();
            $table->string('type', 128)->nullable();
            $table->text('description')->nullable();
            $table->integer('creator')->unsigned();
            $table->foreign('creator')
                ->references('id')->on('users')
                ->onDelete('cascade');
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
		Schema::drop('media');
	}

}
