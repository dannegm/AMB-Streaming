@extends('home/template')

@section('metas')
@stop

@section('styles')
<link rel="stylesheet/less" href="{{URL::asset('/assets/home/less/channel.less')}}">
@stop

@section('scripts')
@stop

@section('content')

	<section id="header"
		@if($channel->has_live() != false && $channel->online == 0)
		<?php $event = $channel->has_live(); ?>
		style="background-image: url('{{URL::asset('/pictures/large/' . $event->background->url)}}');">
		@else
		style="background-image: url('{{URL::asset('/pictures/large/' . $channel->background->url)}}');">
		@endif
		<div class="overlive">
			@if( $channel->logo_uid != "avatarTV" )
			<h1 style="text-align: center;">
				<img src="{{URL::asset("/pictures/normal/" . $channel->logo->url)}}" />
			</h1>
			@else
			<h1>{{$channel->name}}</h1>
			@endif

			@if($channel->has_live() != false && $channel->online == 0)
			<?php $event = $channel->has_live(); ?>
			<div class="media">
				<script>
				(function() {
				var sc=document.createElement("script");sc.type="text/javascript";sc.async=true;
				sc.src="http://video.ambmultimedia.mx/api/widget.js";
				var s=document.getElementsByTagName("script")[0];s.parentNode.insertBefore(sc,s)
				})();
				</script>
				<amb:video uid="{{$event->uid}}" type="event"></amb:video>
			</div>
			@endif

			@if($channel->online != 0)
			<div class="media">
				<script>
				(function() {
				var sc=document.createElement("script");sc.type="text/javascript";sc.async=true;
				sc.src="http://video.ambmultimedia.mx/api/widget.js";
				var s=document.getElementsByTagName("script")[0];s.parentNode.insertBefore(sc,s)
				})();
				</script>
				<amb:video uid="{{$channel->uid}}" type="channel"></amb:video>
			</div>
			@endif
		</div>
	</section>


	<!-- Eventos del canal -->

	<div class="center mtop row tcenter">
		<div class="row">
			@foreach ($channel->events as $event)
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
			@endforeach
		</div>
	</div>

@stop




