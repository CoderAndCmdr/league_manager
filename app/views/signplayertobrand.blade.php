@extends ('_master')

@section('title')
Create a Team
@stop 

@section('content')

{{ Form::open(array('url' => 'createateam', 'method' => 'POST')) }}

<div class='form-group'>

	{{ Form::label('player_id', 'Player') }}
	{{ Form::select('player_id', $players); }}

</div>

<div class='form-group'>

	{{ Form::label('brand_id', 'Brand') }}
	{{ Form::select('brand_id', $brands); }}

</div>

<div class='form-group'>

{{ Form::submit('Submit') }}
{{ Form::close() }}

</div>

@stop  