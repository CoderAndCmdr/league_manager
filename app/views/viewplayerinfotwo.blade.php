@extends ('_master')

@section('title')
Display Team Info
@stop 

@section('content')

<h1>{{ $player['name'] }}</h1>
<br>
Team signed to:
@if ($team->team_name == 'Free Agents')
	None (Free Agent)
@else
	$team->team_name
@endif
<br>
Rating (overall skill level): {{$player->rating}}
<br>
Yearly earnings from brands: ${{$brandearn}}
<br>
Yearly (expected) salary: ${{$player->yearly_salary}}
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