<h1>Search Comic Book</h1>

<form action="search" method="GET">
		<input type="text" name="keyword" @if(isset($keyword)) value="{{$keyword}}" @endif />
		<input type="submit" value="Search">
</form>

@if(isset($listComics))
	<h1> {{count($listComics)}} comics found: </h1>
	@foreach ($listComics as $key=>$comic)
		<h3> <a href="{{route('comic', $comic['data'])}}">{{$key+1}}: {{ $comic['value'] }}</a> <h3>
	@endforeach
@endif