@extends ('_master')

@section('title')
Display Team Info
@stop 

@section('content')

<h1>{{ $team['team_name'] }}</h1>
<h2>Roster:</h2>

@if (count($players)==0)
	No players signed
	<br>
@else 
<p>
	@foreach($players as $player) 
		{{ $player->name; }}
		<br>
	@endforeach
</p>
@endif
<br>

@if (count($players)!=0)
Average player skill rating: {{$average}}
<br>
Total yearly revenue from brands: ${{$revenue}}
<br>
Total player salary expenditures: ${{$expend}} 
@else
Average player skill rating: NA
<br>
Total yearly revenue from brands: $0
<br>
Total player salary expenditures: $0
@endif

@stop  