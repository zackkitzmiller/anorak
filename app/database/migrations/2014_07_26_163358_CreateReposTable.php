<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReposTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('repos', function(Blueprint $table)
		{
			$table->increments('id');

			$table->integer('github_id')->nullable(FALSE);
			$table->tinyInteger('active')->default(0)->nullable(FALSE);
			$table->integer('hook_id');
			$table->string('full_github_name')->nullable(FALSE);
			$table->tinyInteger('private');
			$table->tinyInteger('in_organisation');

			$table->timestamps();

			$table->index('active', 'index_repos_on_active');
			$table->index('github_id', 'index_repos_on_github_id');
		});
	}
}
