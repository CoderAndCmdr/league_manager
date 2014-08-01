<?php 

class Team extends Eloquent { 

	/**
	* Relationship method
	*/
	public function players() {

		# Author has many books
        return $this->hasMany('Player');
        
    }

 }