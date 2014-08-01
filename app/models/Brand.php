<?php 

class Brand extends Eloquent { 

	# Relationship method...
    public function players() {
        
	    # Tags belongs to many Books
	    return $this->belongsToMany('Player');
    }
}