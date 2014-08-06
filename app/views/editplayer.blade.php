@extends ('_master')

@section('title')
Select a player
@stop 

@section('content')

{{ Form::open(array('url' => 'editplayer', 'method' => 'POST')) }}

<div class='form-group'>

	{{ Form::label('player_id', 'Select a player:') }}
	{{ Form::select('player_id', $players); }}

</div>

<div class='form-group'>

	{{ Form::label('team_id', 'Select a team:') }}
	{{ Form::select('team_id', $teams) }}

</div>

<div class='form-group'>

{{ Form::submit('View info') }}
{{ Form::close() }}

</div>

@stop  