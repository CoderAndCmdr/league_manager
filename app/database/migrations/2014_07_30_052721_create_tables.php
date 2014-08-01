<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		 Schema::create('teams', function($table) {

        // Increments method will make a Primary, Auto-Incrementing field.
        // Most tables start off this way
        $table->increments('id');

        // This generates two columns: `created_at` and `updated_at` to
        // keep track of changes to a row
        $table->timestamps();

        // The rest of the fields...
        $table->string('team_name');
        $table->float('average_rating');
        $table->float('monthly_revenue');
        $table->float('monthly_player_expenditures');
        $table->float('percentage');
        
		//
	});

	Schema::create('players', function($table) {

			# AI, PK
			$table->increments('id');

			# created_at, updated_at columns
			$table->timestamps();

			# General data...
			$table->string('name');
			$table->integer('team_id')->unsigned(); # Important! FK has to be unsigned because the PK it will reference is auto-incrementing
			$table->float('rating');
			$table->float('monthly_brand_earnings');
			$table->float('monthly_contract_earnings');
			
			# Define foreign keys...
			$table->foreign('team_id')
				->references('id')
				->on('teams');

		});

	Schema::create('brands', function($table) {

			# AI, PK
			$table->increments('id');

			# created_at, updated_at columns
			$table->timestamps();

			# General data...
			$table->string('name');
			$table->float('monthly_sponsorship');
			# Define foreign keys...
		});

	Schema::create('player_brand', function($table) {

			# AI, PK
			# none needed

			# General data...
			$table->integer('player_id')->unsigned();
			$table->integer('brand_id')->unsigned();

			# Define foreign keys...
			$table->foreign('player_id')->references('id')->on('players');
			$table->foreign('brand_id')->references('id')->on('brands');

		});

    }
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */

	public function down() {

		Schema::table('players', function($table) {
			$table->dropForeign('players_team_id_foreign'); # table_fields_foreign
		  });

		Schema::table('player_brand', function($table) {
			$table->dropForeign('player_brand_player_id_foreign'); # table_fields_foreign
			$table->dropForeign('player_brand_brand_id_foreign');  # table_fields_foreign
		});
		
		Schema::drop('teams');
		Schema::drop('players');
		Schema::drop('brands');
		Schema::drop('player_brand');
	}
}
