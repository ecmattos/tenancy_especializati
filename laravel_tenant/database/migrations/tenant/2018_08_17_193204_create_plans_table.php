<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePlansTable.
 */
class CreatePlansTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('plans', function(Blueprint $table) {
			$table->increments('id');
			
			$table->string('code', 20)->nullable();
            $table->string('description', 100)->nullable();
            $table->string('details', 250)->nullable();
            
            $table->integer('plan_type_id')->unsigned()->default(1);
            $table->foreign('plan_type_id')->references('id')->on('plan_types');

			$table->integer('plan_sub_type_id')->unsigned()->default(1);
			$table->foreign('plan_sub_type_id')->references('id')->on('plan_sub_types');
			
			$table->integer('plan_status_id')->unsigned()->default(1);
            $table->foreign('plan_status_id')->references('id')->on('plan_statuses');

			$table->float('price');
			
			$table->timestamps();
            $table->softDeletes();

            $table->index(['code']);
            $table->index(['description']);
            $table->index(['details']);

            $table->index(['plan_type_id', 'plan_sub_type_id', 'plan_status_id']);

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('plans');
	}
}
