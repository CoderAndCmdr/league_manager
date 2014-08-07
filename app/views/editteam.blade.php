@extends ('_master')

@section('title')
Edit a Team
@stop 

@section('content')

{{ Form::open(array('url' => 'editteam', 'method' => 'POST')) }}

@foreach($errors->all() as $message) 
		<div class='error'>{{ $message }}</div>
@endforeach

<br>

<div class='form-group'>
	
	{{ Form::label('team_id', 'Team to change:') }}
	{{ Form::select('team_id', $teams) }}

</div>

<div class='form-group'>
	
	{{ Form::label('team_name', 'New team name') }}
	{{ Form::text('team_name') }}

</div>

<div class='form-group'>
	
	{{ Form::label('percentage', 'Percentage recieved from brand earnings of players') }}
	{{ Form::text('percentage') }}

</div>

<div class='form-group'>

{{ Form::submit('Update Team') }}
{{ Form::close() }}

</div>

@stop  