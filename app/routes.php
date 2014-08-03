<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('mysql-test', function() {

    # Use the DB component to select all the databases
    $results = DB::select('SHOW DATABASES;');

    # If the "Pre" package is not installed, you should output using print_r instead
    return Pre::render($results);

});

Route::get('/', function(){

	return View::make('hello');
});

Route::get('/createateam', function(){

	return View::make('createteam');
});

Route::post('/createateam', function(){

	$team = new Team;
    $team->team_name = Input::get('team_name');
    $team->percentage = Input::get('percentage');
    $team->save();

    return View::make('hello');
});

Route::get('/createaplayer', function(){

    $teams = Team::getIdNamePair();
	if (count($teams)==0)
	{
		return Redirect::to('/createabrand')->with('flash_message','Must create at least one team first');
	}
	else
	{
		return View::make('createaplayer')->with('teams', $teams);
	}
});

Route::post('/createaplayer', function(){

	$team = Team::find(Input::get('team_id'));
	$player = new Player;
    $player->name = Input::get('name');
    $player->yearly_salary = Input::get('yearly_salary');
    $player->rating = Input::get('rating');
    $player->team()->associate($team); 
    $player->save();

});

Route::get('/createabrand', function(){

    return View::make('createabrand');
});

Route::post('/createabrand', function(){

	$brand = new Brand;
    $brand->name = Input::get('name');
    $brand->yearly_sponsorship = Input::get('yearly_sponsorship');
    $brand->save();

    return View::make('hello');
});

Route::get('/signplayertobrand', function(){

    $brands = Brand::getIdNamePair();
    $players = Player::getIdNamePair();
   

	if ((count($brands)==0) || (count($players)==0))
	{
		return Redirect::to('/createabrand')->with('flash_message','Must create at least one player and one brand first');
	}
	else
	{
		return View::make('signplayertobrand')->with('brands', $brands)->with('players', $players);
	}
});


Route::post('/signplayertobrand', function(){

	$brand = Brand::find(Input::get('brand_id'));
    $player = Player::find(Input::get('player_id'));
	$player->brands()->attach($brand);

     return View::make('hello');
  });


