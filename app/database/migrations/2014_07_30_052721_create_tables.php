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
			$table->integer('team_id')->unsigned()->nullable(); # Important! FK has to be unsigned because the PK it will reference is auto-incrementing
			$table->float('rating');
			$table->float('yearly_salary');
			
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
			$table->float('yearly_sponsorship');
			# Define foreign keys...
		});

	Schema::create('brand_player', function($table) {

			# AI, PK
			# none needed

			# General data...
			$table->integer('brand_id')->unsigned();
			$table->integer('player_id')->unsigned();
			
			# Define foreign keys...
			$table->foreign('brand_id')->references('id')->on('brands');
			$table->foreign('player_id')->references('id')->on('players');
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

		Schema::table('brand_player', function($table) {
			$table->dropForeign('brand_player_brand_id_foreign');  # table_fields_foreign
			$table->dropForeign('brand_player_player_id_foreign'); # table_fields_foreign
		});
		
		Schema::drop('teams');
		Schema::drop('brands');
		Schema::drop('players');
		Schema::drop('brand_player');
	}
}
