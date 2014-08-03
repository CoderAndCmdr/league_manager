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
	
	{{ Form::label('yearly_salary', 'Yearly salary expected by player') }}
	{{ Form::text('yearly_salary') }}

</div>

<div class='form-group'>
	
	{{ Form::label('rating', 'Player skill rating') }}
	{{ Form::text('rating') }}

</div>

<div class='form-group'>

	{{ Form::label('team_id', 'Team') }}
	{{ Form::select('team_id', $teams); }}

</div>

<div class='form-group'>

{{ Form::submit('Submit Player') }}
{{ Form::close() }}

</div>

@stop  