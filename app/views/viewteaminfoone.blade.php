@extends ('_master')

@section('title')
Select a team
@stop 

@section('content')

{{ Form::open(array('url' => 'viewteaminfo', 'method' => 'POST')) }}

<div class='form-group'>

	{{ Form::label('team_id', 'Select a team:') }}
	{{ Form::select('team_id', $teams); }}

</div>

<div class='form-group'>

{{ Form::submit('View info') }}
{{ Form::close() }}

</div>

@stop  