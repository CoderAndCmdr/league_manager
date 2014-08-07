@extends ('_master')

@section('title')
Create a Team
@stop 

@section('content')

{{ Form::open(array('url' => 'signplayertobrand', 'method' => 'POST')) }}

<div class='form-group2'>

	{{ Form::label('player_id', 'Player:') }}
	{{ Form::select('player_id', $players); }}

</div>

<br>

<div class='form-group2'>

	{{ Form::label('brand_id', 'Brand:') }}
	{{ Form::select('brand_id', $brands); }}

</div>

<br>

<div class='form-group2'>

{{ Form::submit('Submit') }}
{{ Form::close() }}

</div>

@stop  