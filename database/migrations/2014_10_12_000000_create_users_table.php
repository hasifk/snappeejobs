<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

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
			$table->string('name');
			$table->string('email')->unique();
			$table->string('password', 60)->nullable();
			$table->string('confirmation_code');
			$table->boolean('confirmed')->default(config('access.users.confirm_email') ? false : true);
			$table->rememberToken();
            $table->string('avatar_filename');
            $table->string('avatar_extension');
            $table->string('avatar_path');
            $table->text('about_me');
            $table->integer('country_id');
            $table->integer('state_id');
			$table->date('dob')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
			$table->boolean('no_password')->default(false);
			$table->integer('employer_id');
			$table->string('group_token');
			$table->timestamps();
			$table->softDeletes();
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
