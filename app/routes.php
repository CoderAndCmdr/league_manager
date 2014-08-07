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
# /app/routes.php

Route::get('/debug', function() {

    echo '<pre>';

    echo '<h1>environment.php</h1>';
    $path   = base_path().'/environment.php';

    try {
        $contents = 'Contents: '.File::getRequire($path);
        $exists = 'Yes';
    }
    catch (Exception $e) {
        $exists = 'No. Defaulting to `production`';
        $contents = '';
    }

    echo "Checking for: ".$path.'<br>';
    echo 'Exists: '.$exists.'<br>';
    echo $contents;
    echo '<br>';

    echo '<h1>Environment</h1>';
    echo App::environment().'</h1>';

    echo '<h1>Debugging?</h1>';
    if(Config::get('app.debug')) echo "Yes"; else echo "No";

    echo '<h1>Database Config</h1>';
    print_r(Config::get('database.connections.mysql'));

    echo '<h1>Test Database Connection</h1>';
    try {
        $results = DB::select('SHOW DATABASES;');
        echo '<strong style="background-color:green; padding:5px;">Connection confirmed</strong>';
        echo "<br><br>Your Databases:<br><br>";
        print_r($results);
    } 
    catch (Exception $e) {
        echo '<strong style="background-color:crimson; padding:5px;">Caught exception: ', $e->getMessage(), "</strong>\n";
    }

    echo '</pre>';

});

Route::get('/', function(){

	if(Auth::check())
		return Redirect::to('/list');
	else
		return Redirect::to('login');

});

Route::get('/list', function(){

	return View::make('mainmenu');

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
        return Redirect::to('/login')->with('flash_message', 'Login failed; please try again.');
   	}

    return Redirect::to('login');

}));

Route::get('/signup', function(){

     return View::make('signup');

});

Route::post('/signup', array('before' => 'csrf', function(){

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
	$user->email = Input::get('email');
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

	return Redirect::to('/list')->with('flash_message', 'Welcome to League Manager!');

}));

Route::get('/logout', array('before' => 'auth', function() {

    # Log out
    Auth::logout();

    # Send them to the homepage
    return Redirect::to('/list');

}));

Route::get('/viewteaminfo', function(){

    $teams = Team::getIdNamePair();
	if (count($teams)==0)
	{
		return Redirect::to('/list')->with('flash_message','No teams to view');
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
	
	if($myteam->team_name == 'Free Agents')
	{
		$expend = 0;
	}

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
		return Redirect::to('/list')->with('flash_message','No players to view');
	}
	else
	{
		return View::make('viewplayerinfoone')->with('players', $players);
	}

});

Route::post('/viewplayerinfo', function(){

	$myplayer = Player::find(Input::get('player_id'));	
	$team = $myplayer->team;
	$brands = $myplayer->brands;
	$sum = 0;
	foreach($brands as $onebr)
		{
			$sum += $onebr->yearly_sponsorship;
		}
	$brandearn = $sum * (100 - $myplayer->team->percentage)/100;

	return View::make('viewplayerinfotwo')->with('player',$myplayer)
	->with('brands',$brands)->with('brandearn',$brandearn)->with('team',$team);	

});

Route::get('/viewbrandinfo', function(){

    $brands = Brand::getIdNamePair();
	if (count($brands)==0)
	{
		return Redirect::to('/list')->with('flash_message','Must create at least one brand first');
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

Route::get('/deletebrand', array('before' => 'auth', function(){

    $brands = Brand::getIdNamePair();
	if (count($brands)==0)
	{
		return Redirect::to('/list')->with('flash_message','No brands to delete');
	}
	else
	{
		return View::make('deletebrand')->with('brands', $brands);
	}

}));

Route::post('/deletebrand', function(){
	
	$mybrand = Brand::find(Input::get('brand_id'));	
	DB::statement('DELETE FROM brand_player WHERE brand_id = ?', array($mybrand->id));
	$mybrand->delete();

	return Redirect::to('/list')->with('flash_message','Brand succesfully deleted');

});

Route::get('/deleteplayer', array('before' => 'auth', function(){

    $players = Player::getIdNamePair();
	if (count($players)==0)
	{
		return Redirect::to('/list')->with('flash_message','No players to delete');
	}
	else
	{
		return View::make('deleteplayer')->with('players', $players);
	}

}));

Route::post('/deleteplayer', function(){

	$myplayer = Player::find(Input::get('player_id'));	
	DB::statement('DELETE FROM brand_player WHERE player_id = ?', array($myplayer->id));
	$myplayer->delete();

	return Redirect::to('/list')->with('flash_message','Player succesfully deleted');

});

Route::get('/deleteteam', array('before' => 'auth', function(){

    $teams = Team::getIdNamePair();
	if (count($teams)==0)
	{
		return Redirect::to('/list')->with('flash_message','No teams to delete');
	}
	else
	{
		return View::make('deleteteam')->with('teams', $teams);
	}

}));

Route::post('/deleteteam', function(){

	$myteam = Team::find(Input::get('team_id'));	
	$players = Player::where('team_id', '=', (Input::get('team_id')))->get();
	
	if ($myteam->team_name == "Free Agents")
	{
		return Redirect::to('/list')->with('flash_message','Cannot delete Free Agents');
	}

	elseif (count($players)==0)
	{
		$myteam->delete();
		return Redirect::to('/list')->with('flash_message','Team succesfully deleted');
	}
	
	else 
	{
		foreach($players as $player)
		{
			$player->team_id = 'Free Agents';
   			$player->save();
		}
		return Redirect::to('/list')->with('flash_message','Players made into free agents, team succesfully deleted');
	}

});


Route::get('/editplayer', array('before' => 'auth', function(){

	$players = Player::getIdNamePair();
	$teams = Team::getIdNamePair();
	if (count($players)==0)
	{
		return Redirect::to('/list')->with('flash_message','No players to edit');
	}
	else
	{
		return View::make('editplayer')->with('teams', $teams)->with('players', $players);
	}
}));

Route::post('/editplayer', function(){

	$rules = array(
			'name' => 'required|alpha_dash',
			'yearly_salary' => 'numeric|required|min:100000',	
			'rating' => 'numeric|min:1|max:99'

		);			
	
	$validator = Validator::make(Input::all(), $rules);

	if($validator->fails()) 
	{
		return Redirect::to('editplayer')
			->with('flash_message', 'Edit failed; please fix the errors listed.')
			->withErrors($validator);
	}
	
	$player = Player::find(Input::get('player_id'));	
	$player->name = Input::get('name');
    $player->yearly_salary = Input::get('yearly_salary');
    $player->rating = Input::get('rating');
    $player->team_id = Input::get('team_id');
    $player->save();
   
    return Redirect::to('/list')->with('flash_message','Player succesfully updated/signed/traded');

});

Route::get('/editteam', array('before' => 'auth', function(){

	$teams = Team::getIdNamePair();
	if (count($teams)==0)
	{
		return Redirect::to('/list')->with('flash_message','No teams to edit');	
	}
	else
	{
		return View::make('editteam')->with('teams', $teams);
	}

}));

Route::post('/editteam', function(){

	$rules = array(
			'team_name' => 'required|alpha_dash|unique:teams',
			'percentage' => 'numeric|required|min:0|max:100',			
		);			
	
		$validator = Validator::make(Input::all(), $rules);

		if($validator->fails()) 
		{
				return Redirect::to('editteam')
				->with('flash_message', ' Creation failed; please fix the errors listed.')
				->withErrors($validator);
		}

	$team = Team::find(Input::get('team_id'));	
	if ($team->team_name == 'Free Agents')
		return Redirect::to('/list')->with('flash_message','Cannot edit Free Agents');	
	$team->team_name = Input::get('team_name');
    $team->percentage = Input::get('percentage');
    $team->save();
	
	return Redirect::to('/list')->with('flash_message','Team succesfully updated');

});

Route::get('/editbrand', array('before' => 'auth', function(){

	$brands = Brand::getIdNamePair();
	if (count($brands)==0)
	{
		return Redirect::to('/list')->with('flash_message','No brands to delete');
	}
	else
	{
		return View::make('editbrand')->with('brands', $brands);
	}

}));

Route::post('/editbrand', function(){

	$rules = array(
			'name' => 'required|alpha_dash:unique:brands',
			'yearly_sponsorship' => 'numeric|required|min:50000',	
		);			
	
		$validator = Validator::make(Input::all(), $rules);

		if($validator->fails()) 
		{
				return Redirect::to('editbrand')
				->with('flash_message', ' Creation failed; please fix the errors listed.')
				->withErrors($validator);
		}

	$brand = Brand::find(Input::get('brand_id'));
	$brand->name = Input::get('name');
    $brand->yearly_sponsorship = Input::get('yearly_sponsorship');
    $brand->save();
	
	return Redirect::to('/list')->with('flash_message','Brand succesfully updated');

});

Route::get('/createateam', array('before'=>'auth', function(){

	return View::make('createteam');
}));

Route::post('/createateam', function(){
	
	$rules = array(
			'team_name' => 'required|alpha_dash|unique:teams',
			'percentage' => 'numeric|required|min:0|max:100',	
			);			
	
		$validator = Validator::make(Input::all(), $rules);

		if($validator->fails()) 
		{
				return Redirect::to('createateam')
				->with('flash_message', ' Creation failed; please fix the errors listed.')
				->withErrors($validator);
		}

	$team = new Team;
    $team->team_name = Input::get('team_name');
    $team->percentage = Input::get('percentage');
    $team->save();
	
	return Redirect::to('/list')->with('flash_message', 'Team succesfully created');

});

Route::get('/createaplayer', array('before' => 'auth', function(){

    $teams = Team::getIdNamePair();
	
	return View::make('createaplayer')->with('teams', $teams);
	
}));

Route::post('/createaplayer', function(){

	$rules = array(
			'name' => 'required|alpha',
			'yearly_salary' => 'numeric|required|min:100000',	
			'rating' => 'numeric|min:1|max:99'

		);			
	
		$validator = Validator::make(Input::all(), $rules);

		if($validator->fails()) 
		{
				return Redirect::to('createaplayer')
				->with('flash_message', ' Creation failed; please fix the errors listed.')
				->withErrors($validator);
		}
	
	$team = Team::find(Input::get('team_id'));
	$player = new Player;
    $player->name = Input::get('name');
    $player->yearly_salary = Input::get('yearly_salary');
    $player->rating = Input::get('rating');
    $player->team()->associate($team); 
    $player->save();
    return Redirect::to('/list')->with('flash_message', 'Player succesfully created');

});

Route::get('/createabrand',  array('before' => 'auth', function(){

    return View::make('createabrand');
}));

Route::post('/createabrand', function(){
		
		$rules = array(
			'name' => 'required|alpha:unique:brands',
			'yearly_sponsorship' => 'numeric|required|min:50000',	
		);			
	
		$validator = Validator::make(Input::all(), $rules);

		if($validator->fails()) 
		{
				return Redirect::to('createabrand')
				->with('flash_message', ' Creation failed; please fix the errors listed.')
				->withErrors($validator);
		}
	$brand = new Brand;
    $brand->name = Input::get('name');
    $brand->yearly_sponsorship = Input::get('yearly_sponsorship');
    $brand->save();

    return Redirect::to('/list')->with('flash_message', 'Brand succesfully created');
});

Route::get('/signplayertobrand',  array('before' => 'auth', function(){

    $brands = Brand::getIdNamePair();
    $players = Player::getIdNamePair();
   

	if ((count($brands)==0) || (count($players)==0))
	{
		return Redirect::to('/list')->with('flash_message','Must create at least one player and one brand first');
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

    return Redirect::to('/list')->with('flash_message','Player succesfully signed to brand');

});




