<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();
		$this->call('FreeAgentsSeeder');
		$this->command->info('Table seeded!');
		// $this->call('UserTableSeeder');
	}

}

class FreeAgentsSeeder extends Seeder {

    public function run()
    {
        DB::table('teams')->delete();

        Team::create(array(
                'team_name' => 'Free Agents',
                'percentage' => 'NULL',
         ));
    }
}