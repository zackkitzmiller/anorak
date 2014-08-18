<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubScriptionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('subscriptions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('repo_id');
			$table->string('stripe_subscription_id');
			$table->softDeletes();
			$table->float('price')->default(0.0);
			$table->timestamps();

			$table->index('repo_id', 'index_subscriptions_on_repo_id');
			$table->index('user_id', 'index_subscriptions_on_user_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('subscriptions');
	}

}
