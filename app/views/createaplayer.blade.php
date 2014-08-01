@extends ('_master')

@section('title')
Create a Player
@stop 

@section('content')

{{ Form::open(array('url' => 'createaplayer', 'method' => 'POST')) }}

<div class='form-group'>
	
	{{ Form::label('name', 'Player name') }}
	{{ Form::text('name') }}

</div>

<div class='form-group'>
	
	{{ Form::label('monthly_brand_earnings', 'total earnings from brands') }}
	{{ Form::text('Monthly Brand Earnings') }}

</div>

<div class='form-group'>
	
	{{ Form::label('monthly_contract_earnings', 'payed by team') }}
	{{ Form::text('Monthly Contract Earnings') }}

</div>

<div class='form-group'>

{{ Form::submit('Submit Player') }}
{{ Form::close() }}

</div>

@stop  