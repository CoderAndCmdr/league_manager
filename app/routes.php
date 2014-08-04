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

Route::get('/list', function(){

	return Redirect::to('/createateam');
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

// Route::post('/login', function(){
// 	View::make('hello');
// });



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
    return Redirect::to('/');

});

Route::get('/trake', function() {

	$email = Auth::user()->email;
	echo $email;

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
		return Redirect::to('/createateam')->with('flash_message','Must create at least one team first');
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




