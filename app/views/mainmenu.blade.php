<!doctype html>
<html>
<head>

	<title>Main menu</title>
	<link rel="stylesheet" href="/Styles/league.css" type="text/css">
</head>

<body>

	@if(Session::get('flash_message'))
		<div class='flash-message'>{{ Session::get('flash_message') }}</div>
	@endif

	<a href='/'><img class='logo' src='<?php echo URL::asset('/images/sports.png'); ?>' alt='League Logo'></a>
	<br>
 
	@if(Auth::check())
		<a href='/logout'>Log out {{ Auth::user()->email; }}</a><br>
	@else 
		<a href='/signup'>Sign up</a> or <a href='/login'>Log in</a>
	@endif
	<h2>League Manager</h2>
	
	<div class='themenu'>
	<a href='/viewteaminfo'>View team info</a> 
	<br>
	<a href='/viewplayerinfo'>View player info</a> 
	<br>
	<a href='/viewbrandinfo'>View brand info</a> 
	<br>	
	<br>
	<a href='/createateam'>Create a team</a>
	<br> 
	<a href='/createaplayer'>Create a player</a> 
	<br>
	<a href='/createabrand'>Create a brand</a> 
	<br>
	<a href='/signplayertobrand'>Sign player to brand</a> 
	<br>
	<br>
	<a href='/editteam'>Edit a team</a> 
	<br>
	<a href='/editplayer'>Edit/trade/sign a player</a> 
	<br>
	<a href='/editbrand'>Edit a brand</a> 
	<br>
	<br>
	<a href='/deleteplayer'>Delete a player</a> 
	<br>
	<a href='/deletebrand'>Delete a brand</a> 
	<br>
	<a href='/deleteteam'>Delete a team</a> 
	</div>
	
</body>

</html>