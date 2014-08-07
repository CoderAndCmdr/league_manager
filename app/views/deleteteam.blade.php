@extends ('_master')

@section('title')
Select a player
@stop 

@section('content')

{{ Form::open(array('url' => 'deleteteam', 'method' => 'POST')) }}

<div class='form-group2'>

	{{ Form::label('team_id', 'Select a team:') }}
	{{ Form::select('team_id', $teams); }}

</div>

<div class='form-group2'>

{{ Form::submit('Delete Team') }}
{{ Form::close() }}

</div>

@stop  