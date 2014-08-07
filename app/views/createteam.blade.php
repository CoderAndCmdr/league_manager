@extends ('_master')

@section('title')
Create a Team
@stop 

@section('content')

{{ Form::open(array('url' => 'createateam', 'method' => 'POST')) }}

@foreach($errors->all() as $message) 
		<div class='error'>{{ $message }}</div>
@endforeach

<br>

<div class='form-group'>
	
	{{ Form::label('team_name', 'Team name:') }}
	{{ Form::text('team_name') }}

</div>

<div class='form-group'>
	
	{{ Form::label('percentage', 'Percentage taken from player brand deals:') }}
	{{ Form::text('percentage') }}

</div>

<div class='form-group2'>

{{ Form::submit('Submit Team') }}
{{ Form::close() }}

</div>

@stop  