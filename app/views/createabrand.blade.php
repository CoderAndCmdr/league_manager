@extends ('_master')

@section('title')
Create a Brand
@stop 

@section('content')

{{ Form::open(array('url' => 'createabrand', 'method' => 'POST')) }}

@foreach($errors->all() as $message) 
		<div class='error'>{{ $message }}</div>
@endforeach

<br>

<div class='form-group'>
	
	{{ Form::label('name', 'Brand name:') }}
	{{ Form::text('name') }}

</div>

<div class='form-group'>
	
	{{ Form::label('yearly_sponsorship', 'Yearly sponsorship payed by brand to player:') }}
	{{ Form::text('yearly_sponsorship') }}

</div>

<div class='form-group2'>

{{ Form::submit('Submit Brand') }}
{{ Form::close() }}

</div>

@stop  