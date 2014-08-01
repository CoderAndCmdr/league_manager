@extends ('_master')

@section('title')
Create a Team
@stop 

@section('content')

{{ Form::open(array('url' => 'createateam', 'method' => 'POST')) }}

<div class='form-group'>
	
	{{ Form::label('team_name', 'Team name') }}
	{{ Form::text('team_name') }}

</div>

<div class='form-group'>
	
	{{ Form::label('percentage', 'Percentage recieved from brand earnings of players') }}
	{{ Form::text('percentage') }}

</div>

<div class='form-group'>

{{ Form::submit('Submit Team') }}
{{ Form::close() }}

</div>

@stop  