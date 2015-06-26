@extends('home/template')

@section('metas')
@stop

@section('styles')
<link rel="stylesheet/less" href="{{URL::asset('/assets/home/less/events.less')}}">
@stop

@section('scripts')
@stop

@section('content')
	<section id="header">
		<div class="overlive">
			<h1>Todos los eventos</h1>
		</div>
	</section>

	<!-- Listado de canales -->
	@foreach ($channels as $channel)
		<div class="center mtop row tcenter">
			<h2>{{$channel->name}}</h2>
			<div class="row">
				@forelse ($channel->events as $event)
				<div class="thumb" {{$event->isLive() ? 'is-live' : ''}}
					style="background-image: url('{{URL::asset('/pictures/medium/' . $event->cover->url)}}');">

					<span class="online">En vivo</span>
					<a class="link" href="{{route('home.event', array('uid' => $event->uid, 'void' => urlencode($event->title)))}}">
					<div class="overlive">
						<h3>{{$event->title}}</h3>
						<h4>{{$event->subtitle}}</h4>
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