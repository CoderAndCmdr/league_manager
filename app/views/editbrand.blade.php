@extends ('_master')

@section('title')
Create a Team
@stop 

@section('content')

{{ Form::open(array('url' => 'editbrand', 'method' => 'POST')) }}

<div class='form-group'>
	
	{{ Form::label('brand_id', 'Brand to change:') }}
	{{ Form::select('brand_id', $brands) }}

</div>

<div class='form-group'>
	
	{{ Form::label('name', 'New brand name:') }}
	{{ Form::text('name') }}

</div>

<div class='form-group'>
	
	{{ Form::label('yearly_sponsorship', 'Yearly sponsorship payed by brand to player:') }}
	{{ Form::text('yearly_sponsorship') }}

</div>

<div class='form-group'>

{{ Form::submit('Update Brand') }}
{{ Form::close() }}

</div>

@stop  