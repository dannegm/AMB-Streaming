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

	<section id="slider">

		<?php $sld = 1; ?>
		@foreach ($marks_events as $event)
		<div class="sld {{ $sld > 1 ? 'next' : 'now' }}" id="step_{{$sld}}"
			style="background-image: url('{{URL::asset('/pictures/large/' . $event->background->url)}}');">
			<div class="overlive">
				@if( $event->logo_uid != "avatarTV" )
				<h2 class="wimage">
					<img src="{{URL::asset("/pictures/normal/" . $event->logo->url)}}" />
				</h2>
				@else
				<h2>{{$event->title}}</h2>
				<p class="sub">{{$event->subtitle}}</p>
				@endif

				@if($event->isLive())
					<p><span class="online">En vivo ahora</span></p>
				@else
					<p><span class="date">{{$event->start_date_human()}}</span></p>
				@endif
				<p><a class="btn" href="{{route('home.event', array('uid' => $event->uid, 'void' => urlencode($event->title)))}}">Ver evento</a></p>
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


	<!-- Últimos eventos -->

	<div id="lastevents" class="center mtop row tcenter">
		<h1>Últimos eventos</h1>
		<div class="row">
			@foreach ($last_events as $event)
			<div class="thumb big" {{$event->isLive() ? 'is-live' : ''}}
				style="background-image: url('{{URL::asset('/pictures/medium/' . $event->cover->url)}}');">

				<span class="online">En vivo</span>

				@if($event->nrecord != 0)
					<span class="nsecuencia">#{{$event->nrecord}}</span>
				@endif

				<a class="link" href="{{route('home.event', array('uid' => $event->uid, 'void' => urlencode($event->title)))}}">
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
				<div class="thumb" {{$event->isLive() ? 'is-live' : ''}}
					style="background-image: url('{{URL::asset('/pictures/medium/' . $event->cover->url)}}');">

					<span class="online">En vivo</span>

					@if($event->nrecord != 0)
						<span class="nsecuencia">#{{$event->nrecord}}</span>
					@endif


					<a class="link" href="{{route('home.event', array('uid' => $event->uid, 'void' => urlencode($event->title)))}}">
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
			<p><a href="{{route('home.channel', array('uid' => $channel->uid, 'void' => urlencode($channel->name)))}}" class="seemore">ver todos los eventos de {{$channel->name}}</a></p>
		</div>
	@endforeach

@stop




