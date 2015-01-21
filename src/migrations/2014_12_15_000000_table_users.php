<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableUsers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('username', 30);
            $table->string('password', 60);
            $table->string('firstname', 60);
            $table->string('lastname', 60);
            $table->string('nickname', 60);
            $table->integer('level'); // level of roles 1 : administrator, 2 : editor, 3 : subscriber
            $table->integer('creator')->unsigned()->nullable();
            $table->foreign('creator')
                ->references('id')->on('users');
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
		Schema::drop('users');
	}

}
