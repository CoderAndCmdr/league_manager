<?php

class FreeAgentsSeeder extends Seeder {

    public function run()
    {
        //DB::table('Free Agents')->delete();

        $freeagents = array(
                'team_name' => 'Free Agents',
                'percentage' => 'NULL',
         );

        DB::table('teams')->insert( $freeagents );
    }

}