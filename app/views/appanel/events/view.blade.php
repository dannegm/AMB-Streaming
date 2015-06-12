@extends('appanel/template')

@section('content')
	<ol class="breadcrumb">
		<li><a href="{{route('appanel')}}">Inicio</a></li>
		<li><a href="{{route('appanel.events.index')}}">Eventos</a></li>
		<li>Información</li>
		<li class="active">{{$event->uid}}</li>
	</ol>

	<div class="row">
		<div class="col-md-12">
			<h3>{{$event->title}}</h3>
			@if($event->isLive())
			<p><span class="label label-danger">En vivo</span></p>
			@endif
			<blockquote>
				<footer>Sku: {{$event->uid}}</footer>
			</blockquote>
		</div>
	</div>

	<div class="btn-toolbar" style="margin-bottom: 1em;">
		<a target="_blank" href="{{route('home.event', array('uid' => $event->uid, 'void' => urlencode($event->title)))}}" class="btn btn-primary btn-sm" role="button">Landing page</a>
		<a href="{{route('appanel.channels.view', array('uid' => $event->channel->uid))}}" class="btn btn-default btn-sm" role="button">Canal <b>{{$event->channel->name}}</b></a>

		@if(Auth::user()->permissions()->events->edit)
		<a href="{{route('appanel.events.edit', array('uid' => $event->uid))}}" class="btn btn-default btn-sm" role="button">Editar</a>
		@endif

		<a href="#" class="btn btn-default btn-sm" role="button" disabled="disabled">Ver estadísticas</a>

		@if($event->isLive())
			@if(Auth::user()->permissions()->events->edit)
			<a href="#" class="btn btn-default btn-sm" role="button" disabled="disabled">Extender 1hr</a>
			<a href="#" class="btn btn-danger btn-sm" role="button" disabled="disabled">Terminar</a>
			@endif
		@else
			@if(Auth::user()->permissions()->events->delete)
			<a href="{{route('appanel.events.delete', array('uid' => $event->uid))}}" class="btn btn-danger btn-sm" role="button">Eliminar</a>
			@endif
		@endif
	</div>

	<div class="row">
		<div class="col-md-12">
			<h5>Información RTMP</h5>
			<blockquote style="font-size: 1em;">
				<dl class="dl-horizontal">
					<dt>Código</dt>
					<dd><code>{{$event->channel->rtmp}}</code></dd>
				</dl>
				<dl class="dl-horizontal">
					<dt>Stream</dt>
					<dd><code>{{$event->channel->rtmp_stream}}</code></dd>
				</dl>
				<dl class="dl-horizontal">
					<dt>Usuario</dt>
					<dd><code>{{$event->channel->rtmp_user}}</code></dd>
				</dl>
				<dl class="dl-horizontal">
					<dt>Contraseña</dt>
					<dd><code>{{$event->channel->rtmp_pass}}</code></dd>
				</dl>
			</blockquote>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<h5>Enlace a la plataforma</h5>
			<pre><a target="_blank" href="{{route('home.event', array('uid' => $event->uid, 'void' => urlencode($event->title)))}}">{{route('home.event', array('uid' => $event->uid, 'void' => urlencode($event->title)))}}</a></pre>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="input-field extend">
				<h5>Código de inserción</h5>
				<pre class="copypaste">
&lt;script&gt;
(function() {
var sc=document.createElement("script");sc.type="text/javascript";sc.async=true;
sc.src="//video.ambmultimedia.mx/api/widget.js";
var s=document.getElementsByTagName("script")[0];s.parentNode.insertBefore(sc,s)
})();
&lt;/script&gt;
&lt;amb:video uid="{{$event->uid}}" type="event"&gt;&lt;/amb:video&gt;</pre>
			</div>
		</div>
	</div>
@stop