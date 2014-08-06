@extends ('_master')

@section('title')
Display Team Info
@stop 

@section('content')

<h1>{{ $player['name'] }}</h1>
<br>
Rating (overall skill level): {{$player->rating}}
<br>
Yearly earnings from brands: ${{$brandearn}}
<br>
Yearly salary: ${{$player->yearly_salary}}
<br>
<br>
Brands signed to:
@if (count($brands)==0)
	<br>
	None
@else 
<p>
	@foreach($brands as $brand) 
		{{ $brand->name }}
		<br>
	@endforeach
</p>
@endif
<br>

@stop  