<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuildsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('builds', function(Blueprint $table)
		{
			$table->increments('id');

			$table->text('violations');
			$table->integer('repo_id');
			$table->string('uuid')->nullable(FALSE);

			$table->timestamps();

			$table->index('repo_id', 'index_builds_on_repo_id');
			$table->index('uuid', 'index_builds_on_uuid');
		});
	}

}
