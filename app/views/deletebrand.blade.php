@extends ('_master')

@section('title')
Select a brand
@stop 

@section('content')

{{ Form::open(array('url' => 'deletebrand', 'method' => 'POST')) }}

<div class='form-group2'>

	{{ Form::label('brand_id', 'Select a brand:') }}
	{{ Form::select('brand_id', $brands); }}

</div>

<div class='form-group2'>

{{ Form::submit('Delete Brand') }}
{{ Form::close() }}

</div>

@stop  