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

Route::get('/login', function(){

     return View::make('login');

});

Route::post('/login', array('before' => 'csrf', function() {

            $credentials = Input::only('email', 'password');

            if (Auth::attempt($credentials, $remember = true)) 
            {
                return Redirect::intended('/')->with('flash_message', 'Welcome Back!');
            }
            else 
            {
                return Redirect::to('/login')->with('flash_message', 'Log in failed; please try again.');
            }

            return Redirect::to('login');
        }
    )

);

Route::get('/signup', function(){

     return View::make('signup');

});

Route::post('/signup', function(){

    $rules = array(
			'email' => 'required|email|unique:users,email',
			'password' => 'required|min:6'	
		);			

		# Step 2) 		
		$validator = Validator::make(Input::all(), $rules);

		# Step 3
		if($validator->fails()) 
		{

			return Redirect::to('/signup')
				->with('flash_message', 'Sign up failed; please fix the errors listed.')
				->withErrors($validator);
		}

		$user = new User;
		$user->email    = Input::get('email');
		$user->password = Hash::make(Input::get('password'));

		try {
			$user->save();
		}
		catch (Exception $e) {
			return Redirect::to('/signup')
				->with('flash_message', 'Sign up failed; please try again.')
				->withInput();
		}

		# Log in
		Auth::login($user);

		return Redirect::to('/createateam')->with('flash_message', 'Welcome to Foobooks!');

});

Route::get('/logout', function() {

    # Log out
    Auth::logout();

    # Send them to the homepage
    return Redirect::to('/list');

});

Route::get('/viewteaminfo', function(){

    $teams = Team::getIdNamePair();
	if (count($teams)==0)
	{
		return Redirect::to('/createateam')->with('flash_message','Must create at least one team first');
	}
	else
	{
		return View::make('viewteaminfoone')->with('teams', $teams);
	}

});

Route::post('/viewteaminfo', function(){

	$myteam = Team::find(Input::get('team_id'));	
	$players = Player::where('team_id', '=', (Input::get('team_id')))->get();
	$ratingsum=0;
	$totalrev=0;
	$expend=0;
	
	foreach ($players as $player)
	{
		$ratingsum += $player->rating;
		$expend += $player->yearly_salary;
		$mybrands = $player->brands;
			
		foreach($mybrands as $onebr)
		{
			$totalrev += $onebr->yearly_sponsorship;
		}
	}
	  
	$revenue = $totalrev * ($myteam->percentage)/100;
	if (count($players)!=0)
		$average = $ratingsum / count($players);
	if (count($players)==0)
		return View::make('viewteaminfotwo')->with('team',$myteam)->with('players',$players);
	else
	{
		return View::make('viewteaminfotwo')->with('players',$players)->with('team',$myteam)->
		with('revenue',$revenue)->with('expend',$expend)->with('average',$average);
	}
});

Route::get('/viewplayerinfo', function(){

    $players = Player::getIdNamePair();
	if (count($players)==0)
	{
		return Redirect::to('/createaplayer')->with('flash_message','Must create at least one player first');
	}
	else
	{
		return View::make('viewplayerinfoone')->with('players', $players);
	}

});

Route::post('/viewplayerinfo', function(){

	$myplayer = Player::find(Input::get('player_id'));	
	$brands = $myplayer->brands;
	$sum = 0;
	foreach($brands as $onebr)
		{
			$sum += $onebr->yearly_sponsorship;
		}
	$brandearn = $sum * (100 - $myplayer->team->percentage)/100;

	return View::make('viewplayerinfotwo')->with('player',$myplayer)
	->with('brands',$brands)->with('brandearn',$brandearn);	

});

Route::get('/viewbrandinfo', function(){

    $brands = Brand::getIdNamePair();
	if (count($brands)==0)
	{
		return Redirect::to('/createabrand')->with('flash_message','Must create at least one brand first');
	}
	else
	{
		return View::make('viewbrandinfoone')->with('brands', $brands);
	}

});

Route::post('/viewbrandinfo', function(){

	$mybrand = Brand::find(Input::get('brand_id'));	
	$players = $mybrand->players;
	
	return View::make('viewbrandinfotwo')->with('players',$players)
	->with('brand',$mybrand);

});

Route::get('/deletebrand', function(){

    $brands = Brand::getIdNamePair();
	if (count($brands)==0)
	{
		return Redirect::to('/createabrand')->with('flash_message','Must create at least one brand first');
	}
	else
	{
		return View::make('deletebrand')->with('brands', $brands);
	}

});

Route::post('/deletebrand', function(){
	
	$mybrand = Brand::find(Input::get('brand_id'));	
	DB::statement('DELETE FROM brand_player WHERE brand_id = ?', array($mybrand->id));
	$mybrand->delete();
	Redirect::to('/createateam')->with('flash_message','Brand succesfully deleted');

});

Route::get('/deleteplayer', function(){

    $players = Player::getIdNamePair();
	if (count($players)==0)
	{
		return Redirect::to('/createabrand')->with('flash_message','Must create at least one player first');
	}
	else
	{
		return View::make('deleteplayer')->with('players', $players);
	}

});

Route::post('/deleteplayer', function(){

	$myplayer = Player::find(Input::get('player_id'));	
	DB::statement('DELETE FROM brand_player WHERE player_id = ?', array($myplayer->id));
	$myplayer->delete();
	return Redirect::to('/createateam')->with('flash_message','Player succesfully deleted');

});

Route::get('/deleteteam', function(){

    $players = Player::getIdNamePair();
	if (count($players)==0)
	{
		return Redirect::to('/createabrand')->with('flash_message','Must create at least one player first');
	}
	else
	{
		return View::make('deleteplayer')->with('players', $players);
	}

});

Route::post('/deleteplayer', function(){

	$myplayer = Player::find(Input::get('player_id'));	
	DB::statement('DELETE FROM brand_player WHERE player_id = ?', array($myplayer->id));
	$myplayer->delete();
	return Redirect::to('/createateam')->with('flash_message','Player succesfully deleted');

});


Route::get('/editplayer', function(){

	$players = Player::getIdNamePair();
	$teams = Team::getIdNamePair();
	return View::make('editplayer')->with('teams', $teams)->with('players', $players);

});


Route::post('/editplayer', function(){
	
	$player = Player::find(Input::get('player_id'));	
	$player->name = Input::get('name');
    $player->yearly_salary = Input::get('yearly_salary');
    $player->rating = Input::get('rating');
    $myteam = Team::find(Input::get('team_id'));
    $player->team_id = Input::get('team_id');
	$player->save();

});

Route::get('/editteam', function(){

	$teams = Team::getIdNamePair();
	return View::make('editteam')->with('teams', $teams);

});

Route::post('/editteam', function(){
	
	$team = Team::find(Input::get('team_id'));	
	$team->team_name = Input::get('team_name');
    $team->percentage = Input::get('percentage');
    $team->save();
	$team->save();
	return Redirect::to('/createateam')->with('flash_message','Team succesfully edited');

});

Route::get('/editbrand', function(){

	$brands = Brand::getIdNamePair();
	return View::make('editbrand')->with('brands', $brands);

});

Route::post('/editbrand', function(){

	$brand = Brand::find(Input::get('brand_id'));
	$brand->name = Input::get('name');
    $brand->yearly_sponsorship = Input::get('yearly_sponsorship');
    $brand->save();
	return Redirect::to('/createateam')->with('flash_message','Brand succesfully edited');

});

Route::get('/trake', function() {

	$email = Auth::user()->email;
	echo $email;

});

Route::get('/createateam', array('before'=>'auth', function(){

	return View::make('createteam');
}));

Route::post('/createateam', function(){

	$team = new Team;
    $team->team_name = Input::get('team_name');
    $team->percentage = Input::get('percentage');
    $team->save();

    return View::make('hello');
});

Route::get('/createaplayer', array('before' => 'auth', function(){

    $teams = Team::getIdNamePair();
	if (count($teams)==0)
	{
		return Redirect::to('/createateam')->with('flash_message','Must create at least one team first');
	}
	else
	{
		return View::make('createaplayer')->with('teams', $teams);
	}
}));

Route::post('/createaplayer', function(){

	$team = Team::find(Input::get('team_id'));
	$player = new Player;
    $player->name = Input::get('name');
    $player->yearly_salary = Input::get('yearly_salary');
    $player->rating = Input::get('rating');
    $player->team()->associate($team); 
    $player->save();

});

Route::get('/createabrand',  array('before' => 'auth', function(){

    return View::make('createabrand');
}));

Route::post('/createabrand', function(){

	$brand = new Brand;
    $brand->name = Input::get('name');
    $brand->yearly_sponsorship = Input::get('yearly_sponsorship');
    $brand->save();

    return View::make('hello');
});

Route::get('/signplayertobrand',  array('before' => 'auth', function(){

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
}));

Route::post('/signplayertobrand', function(){

	$player = Player::find(Input::get('player_id'));
	$brand = Brand::find(Input::get('brand_id'));

	$player->brands()->attach($brand);

     return View::make('hello');

});




