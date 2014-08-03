<?php 

class Brand extends Eloquent { 

	# Relationship method...
    public function players() {
        
	    # Tags belongs to many Books
	    return $this->belongsToMany('Player');
    }

    public static function getIdNamePair() {

		$brands = Array();

		$collection = Brand::all();	

		foreach($collection as $brand) {
			$brands[$brand->id] = $brand->name;
		}	

		return $brands;	
	}

}