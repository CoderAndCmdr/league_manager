<!doctype html>
<html>
<head>

	<title> @yield('title','League_Manager')</title>

</head>

<body>

	@if(Session::get('flash_message'))
		<div class='flash-message'>{{ Session::get('flash_message') }}</div>
	@endif

	<!-- <a href='/'><img class='logo' src='<?php echo URL::asset('/images/logo@2x.png'); ?>' alt='Foobooks Logo'></a>
 -->
<!-- 	@if(Auth::check())
		<a href='/logout'>Log out {{ Auth::user()->email; }}</a><br><br>
		<a href='/teamview'>View all Teams</a> | 
		<a href='/playerview'>View all Players</a> 
	@else 
		<a href='/signup'>Sign up</a> or <a href='/login'>Log in</a>
	@endif -->
	
	@yield('content')

</body>

</html>