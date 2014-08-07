@extends ('_master')

@section('title')
Select a player
@stop 

@section('content')

{{ Form::open(array('url' => 'viewplayerinfo', 'method' => 'POST')) }}

<div class='form-group2'>

	{{ Form::label('player_id', 'Select a player:') }}
	{{ Form::select('player_id', $players); }}

</div>

<div class='form-group2'>

{{ Form::submit('View info') }}
{{ Form::close() }}

</div>

@stop  