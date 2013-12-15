<?php

use Illuminate\Database\Migrations\Migration;

class Init extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('accounts', function($table) {
			$table->integer('id')->unsigned();
			$table->string('nr', 15);
			$table->string('bank_code', 15);
			$table->string('name', 255);
			$table->string('type', 255);
			$table->string('customer', 255);
			$table->string('currency', 6);
			$table->string('iban', 40);
			$table->string('bic', 15);
			$table->float('balance');
			$table->timestamp('balance_date');

			$table->timestamps();
			$table->softDeletes();

			$table->primary('id');
		});

		Schema::create('turnovers', function($table) {
			$table->increments('id');
			$table->integer('account_id')->unsigned();
			$table->string('to_accountnr', 40)->nullable();
			$table->string('to_bank_code', 15)->nullable();
			$table->string('to_name', 255)->nullable();
			$table->float('value');
			$table->string('purpose_1', 35)->nullable();
			$table->string('purpose_2', 35)->nullable();
			$table->text('purpose_3')->nullable();
			$table->timestamp('date_booking');
			$table->timestamp('date_value');
			$table->string('type', 100);
			$table->text('comment')->nullable();
			$table->string('gvcode', 3);

			$table->timestamps();

			$table->index('to_accountnr');
			$table->index('to_bank_code');
			$table->index('to_name');
			$table->foreign('account_id')->references('id')->on('accounts');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('turnovers');
		Schema::dropIfExists('accounts');
	}

}