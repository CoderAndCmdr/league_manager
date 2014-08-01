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

    return View::make('createaplayer');
});

Route::post('/createaplayer', function(){

	$player = new Player;
    $player->name = Input::get('name');
    $player->monthly_brand_earnings = Input::get('monthly_brand_earnings');
    $player->monthly_contract_earnings = Input::get('monthly_contract_earnings');
    $player->save();

    return View::make('hello');
});

