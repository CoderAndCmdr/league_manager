@extends ('_master')

@section('title')
Select a brand
@stop 

@section('content')

{{ Form::open(array('url' => 'viewbrandinfo', 'method' => 'POST')) }}

<div class='form-group'>

	{{ Form::label('brand_id', 'Select a brand:') }}
	{{ Form::select('brand_id', $brands); }}

</div>

<div class='form-group'>

{{ Form::submit('View info') }}
{{ Form::close() }}

</div>

@stop  