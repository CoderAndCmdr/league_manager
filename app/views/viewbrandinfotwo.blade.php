@extends ('_master')

@section('title')
Display Brand Info
@stop 

@section('content')

<h1>{{ $brand['name'] }}</h1>
<br>
Yearly Sponsorship deal offered to a player: ${{$brand->yearly_sponsorship}}
<br>
Total players signed: {{count($players)}}
<br>
<br>
Players signed:
@if (count($players)==0)
	<br>
	None
@else 
<p>
	@foreach($players as $player) 
		{{ $player->name }}
		<br>
	@endforeach
</p>
@endif
<br>

@stop  