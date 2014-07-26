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

			$table->string('github_username')->nullable(FALSE);
			$table->rememberToken();
			$table->string('email_address');

			$table->timestamps();

			$table->index('remember_token', 'index_users_on_remember_token');
		});
	}

}
