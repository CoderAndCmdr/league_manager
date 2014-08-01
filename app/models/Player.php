<?php 

class Player extends Eloquent { 

	# The guarded properties specifies which attributes should *not* be mass-assignable
	protected $guarded = array('id', 'created_at', 'updated_at');

	# Relationship method...
    public function team() {
    
    	# Books belongs to Author
	    return $this->belongsTo('Team');
    }
    
    # Relationship method...
    public function brands() {
    
    	# Books belong to many Tags
        return $this->belongsToMany('Brand');
    }

}