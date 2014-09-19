<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBuildTimeColumnToBuildsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('builds', function(Blueprint $table)
		{
			$table->float('time_taken')->default(0)->after('repo_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('builds', function(Blueprint $table)
		{
			$table->dropColumn('time_taken');
		});
	}

}
