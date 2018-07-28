<h1>{{$title}}</h1>
<img src="{{$image}}" />
<h1>List Chapters</h1>
@foreach (array_reverse($chapters) as $key => $comic)
	<h3> <a href="{{ url('read/'.$titleComic.'/'.$comic['url']) }}" >{{$key+1}}: {{ $comic['title'] }}</a> <h3>
@endforeach
