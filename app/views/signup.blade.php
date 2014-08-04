@extends('_master')

@section('title')
	Sign up
@stop

@section('content')

	<h1> Signup </h1>

	@foreach($errors->all() as $message) 
		<div class='error'>{{ $message }}</div>
	@endforeach
	
	<br>
	
	{{ Form::open(array('url' => '/signup')) }}

		Email
		{{ Form::text('email') }}
		<br>
		Password:
		{{ Form::password('password') }}
		<small>Min: 6</small><br><br>

		{{ Form::submit('Submit') }}

	{{ Form::close() }}

@stop

