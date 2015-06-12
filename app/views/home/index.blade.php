@extends('home/template')

@section('metas')
@stop

@section('styles')
<link rel="stylesheet/less" href="{{URL::asset('/assets/home/less/home.less')}}">
@stop

@section('scripts')
<script src="{{URL::asset('/assets/home/js/dnn.slider.js')}}"></script>
@stop

@section('content')

	@if(true)
	<section id="slider">

		<?php $sld = 1; ?>
		@foreach ($last_events as $event)
		<div class="sld {{ $sld > 1 ? 'next' : 'now' }}" id="step_{{$sld}}"
			style="background-image: url('{{URL::asset('/pictures/large/' . $event->background->url)}}');">
			<div class="overlive">
				<h2>{{$event->title}}</h2>
				<p class="sub">{{$event->subtitle}}</p>
				@if(strtotime($event->ended_at) > time() && strtotime($event->started_at) < time())
					<p>En vivo ahora</p>
				@else
					<p>{{$event->start_date_human()}}</p>
				@endif
				<p><a class="btn" href="{{URL::asset('/event/' . $event->uid . '/void')}}">Ver evento</a></p>
			</div>
		</div>
		<?php $sld++; ?>
		@endforeach

		<ul id="dots">
			<?php $sld = 1; ?>
			@foreach ($last_events as $event)
			<li id="dot_{{$sld}}" data-step="{{$sld}}"{{ $sld > 1 ? '' : ' class="active"' }}></li>
			<?php $sld++; ?>
			@endforeach
		</ul>

	</section>
	@else
	<section id="slider">

		<?php $sld = 1; ?>
		@foreach ($last_events as $event)
		<div class="sld {{ $sld > 1 ? 'next' : 'now' }}" id="step_{{$sld}}"
			style="background-image: url('{{URL::asset('/pictures/large/' . $event->background->url)}}');">
			<div class="overlive2">
				<img src="{{URL::asset('/pictures/large/' . $event->cover->url)}}" />

				<h2>{{$event->title}}</h2>
				@if(strtotime($event->ended_at) > time() && strtotime($event->started_at) < time())
					<p>En vivo ahora</p>
				@else
					<p>{{$event->start_date_human()}}</p>
				@endif
				<p><a class="btn" href="{{URL::asset('/event/' . $event->uid . '/void')}}">Ver evento</a></p>
			</div>
		</div>
		<?php $sld++; ?>
		@endforeach

		<ul id="dots">
			<?php $sld = 1; ?>
			@foreach ($last_events as $event)
			<li id="dot_{{$sld}}" data-step="{{$sld}}"{{ $sld > 1 ? '' : ' class="active"' }}></li>
			<?php $sld++; ?>
			@endforeach
		</ul>

	</section>
	@endif


	<!-- Últimos eventos -->

	<div class="center mtop row tcenter">
		<h1>Últimos eventos</h1>
		<div class="row">
			@foreach ($last_events as $event)
			<div class="thumb big"
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
			@endforeach
		</div>
	</div>

	<!-- Listado de canales -->
	@foreach ($channels as $channel)
	<div class="center mtop row tcenter">
		<h2>{{$channel->name}}</h2>
		<div class="row">
			@forelse ($channel->last_events(4) as $event)
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




