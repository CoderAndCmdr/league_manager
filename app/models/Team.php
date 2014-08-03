<?php 

class Team extends Eloquent { 

	/**
	* Relationship method
	*/
	public function players() {

		# Author has many books
        return $this->hasMany('Player');
        
    }

    	public static function getIdNamePair() {

		$teams = Array();

		$collection = Team::all();	

		foreach($collection as $team) {
			$teams[$team->id] = $team->team_name;
		}	

		return $teams;	
	}

  	
}

 