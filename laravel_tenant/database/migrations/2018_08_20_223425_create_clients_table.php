<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateClientsTable.
 */
class CreateClientsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('clients', function(Blueprint $table) {
			$table->increments('id');
			
			$table->string('code', 12)->unique();
			$table->string('cpfcnpj', 15)->unique();
			$table->string('name', 50);
			$table->string('email', 30)->unique();
            $table->string('domain', 50);
            $table->string('database', 50)->unique();
            $table->string('hostname', 50);
            $table->string('username', 50);
			$table->string('password', 50);

			$table->rememberToken();
			
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
		Schema::drop('clients');
	}
}
