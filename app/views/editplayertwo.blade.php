@extends ('_master')

@section('title')
Edit a Player
@stop 

@section('content')

<h2>Edit {{$player}}</h2>

{{ Form::open(array('url' => 'editplayer', 'method' => 'POST')) }}

<div class='form-group'>
	
	{{ Form::label('team_id', 'Team') }}
	{{ Form::select('team_id', $teams) }}

</div>

<div class='form-group'>
	
	{{ Form::label('yearly_salary', 'Yearly salary expected by player') }}
	{{ Form::text('yearly_salary') }}

</div>

<div class='form-group'>
	
	{{ Form::label('rating', 'Player skill rating') }}
	{{ Form::text('rating') }}

</div>


Would you like to change the player's teams?
<div class='form-group'>

	{{ Form::label('team_id', 'Team') }}
	{{ Form::select('team_id', $teams) }}
	 <option value="None">None</option>

</div>

<div class='form-group'>

{{ Form::submit('Submit Player') }}
{{ Form::close() }}

</div>

@stop 