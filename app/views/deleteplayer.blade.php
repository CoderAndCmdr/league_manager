@extends ('_master')

@section('title')
Select a player
@stop 

@section('content')

{{ Form::open(array('url' => 'deleteplayer', 'method' => 'POST')) }}

<div class='form-group'>

	{{ Form::label('player_id', 'Select a player:') }}
	{{ Form::select('player_id', $players); }}

</div>

<div class='form-group'>

{{ Form::submit('Delete Player') }}
{{ Form::close() }}

</div>

@stop  