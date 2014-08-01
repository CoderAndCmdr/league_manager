@extends ('_master')

@section('title')
Create a Player
@stop 

@section('content')

{{ Form::open(array('url' => 'createaplayer', 'method' => 'POST')) }}

<div class='form-group'>
	
	{{ Form::label('name', 'Player name') }}
	{{ Form::text('name') }}

</div>

<div class='form-group'>
	
	{{ Form::label('monthly_contract_earnings', 'Monthly contract wage payed by team') }}
	{{ Form::text('monthly_contract_earnings') }}

</div>

<div class='form-group'>

{{ Form::submit('Submit Player') }}
{{ Form::close() }}

</div>

@stop  