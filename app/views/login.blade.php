@extends('_master')

@section('title')
	Login
@stop

@section('content')

	<h1> Login </h1>

	{{ Form::open(array('url' => '/login')) }}

		Email
		{{ Form::text('email') }}
		<br>
		Password:
		{{ Form::password('password') }}
		<small>Min: 6</small><br><br>

		{{ Form::submit('Submit') }}

	{{ Form::close() }}

@stop

