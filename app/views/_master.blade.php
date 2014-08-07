<!doctype html>
<html>
<head>

	<title> @yield('title','League_Manager')</title>
	<link href="" rel="stylesheet">
	<link rel="stylesheet" href="/styles/league.css" type="text/css">

</head>

<body>

	@if(Session::get('flash_message'))
		<div class='flash-message'>{{ Session::get('flash_message') }}</div>
		<br>
	@endif

	<a href='/'><img class='logo' src='<?php echo URL::asset('/images/sports.png'); ?>' alt='League Logo'></a>
    <br>
	@if(Auth::check())
		<a href='/logout'>Log out {{ Auth::user()->email; }}</a>  
		<a class='links' href='/list'>Go to main menu</a>
	@else 
		<a href='/signup'>Sign up</a> or <a href='/login'>Log in</a>
		<a class='links' href='/list'>Go to main menu</a>
	@endif
	
	<h2>League Manager</h2>
	
	@yield('content')

</body>

</html>