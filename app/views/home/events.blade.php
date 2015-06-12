@extends('home/template')

@section('metas')
@stop

@section('styles')
@stop

@section('scripts')
@stop

@section('content')
	<div class="center mtop row">
		<h1>Todos los eventos</h1>
	</div>

	<!-- Listado de canales -->
	@foreach ($channels as $channel)
	<div class="center mtop row tcenter">
		<h2>{{$channel->name}}</h2>
		<div class="row">
			@forelse ($channel->events as $event)
			<div class="thumb"
				style="background-image: url('{{URL::asset('/pictures/medium/' . $event->cover->url)}}');">
				<a class="link" href="{{URL::asset('/event/' . $event->uid . '/' . urlencode($event->title))}}">
				<div class="overlive">
					<h3>{{$event->title}}</h3>
					<div class="offcanvas">
						<p>{{$event->start_date_human()}}</p>
						<span class="btn">Ver evento</span>
					</div>
				</div>
				</a>
			</div>
			@empty
			<div class="col-12">
				<p>Este canal no tiene eventos</p>
			</div>
			@endforelse
		</div>
	</div>
	@endforeach

@stop