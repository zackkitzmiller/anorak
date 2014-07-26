<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberShipsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('memberships', function(Blueprint $table)
		{
			$table->increments('id');

			$table->integer('user_id')->nullable(FALSE);
			$table->integer('repo_id')->nullable(FALSE);

			$table->timestamps();

			$table->index(array('repo_id', 'user_id'), 'index_memberships_on_repo_id_and_user_id');
		});
	}

}
