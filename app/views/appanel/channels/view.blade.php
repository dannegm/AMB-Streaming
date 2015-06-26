@extends('appanel/template')

@section('content')
	<ol class="breadcrumb">
		<li><a href="{{route('appanel')}}">Inicio</a></li>
		<li><a href="{{route('appanel.channels.index')}}">Canales</a></li>
		<li>Información</li>
		<li class="active">{{$channel->name}}</li>
	</ol>

	<div class="row">
		<div class="col-md-12">
			<h3>{{$channel->name}}</h3>
			<blockquote>
				<footer>Sku: {{$channel->uid}}</footer>
			</blockquote>
		</div>
	</div>

	<div class="btn-toolbar" style="margin-bottom: 1em;">
		<a target="_blank" href="{{route('home.channel', array('uid' => $channel->uid, 'void' => urlencode($channel->name)))}}" class="btn btn-primary btn-sm" role="button">Landing page</a>

		@if(Auth::user()->permissions()->channels->edit)
			@if(!$channel->has_live())
				@if($channel->online != 0)
				<a href="{{route('appanel.channels.put.offline', array('uid' => $channel->uid))}}" class="btn btn-warning btn-sm" role="button">Poner Offline</a>
				@else
				<a href="{{route('appanel.channels.put.online', array('uid' => $channel->uid))}}" class="btn btn-success btn-sm" role="button">Poner Online</a>
				@endif
			@endif

			<a href="{{route('appanel.channels.edit', array('uid' => $channel->uid))}}" class="btn btn-default btn-sm" role="button">Editar</a>
		@endif

		<a href="#" class="btn btn-default btn-sm" role="button" disabled="disabled">Ver estadísticas</a>
		@if(!$channel->has_live())
			@if(Auth::user()->permissions()->channels->delete)
			<a href="{{route('appanel.channels.delete', array('uid' => $channel->uid))}}" class="btn btn-danger btn-sm" role="button">Eliminar</a>
			@endif
		@endif
	</div>

	@if($channel->has_live() != false && $channel->online == 0)
	<?php $event = $channel->has_live(); ?>
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">En vivo ahora</h3>
		</div>
		<div class="panel-body">
			<div class="media">
				<div class="media-left">
					<img class="media-object img-rounded" src="{{URL::asset('/pictures/thumb/' . $event->cover->url)}}">
				</div>
				<div class="media-body">
					<h4 class="media-heading">{{$event->title}}</h4>
					<p>{{$event->start_date_human()}}</p>
					<p>{{$event->subtitle}}</p>
				</div>
			</div>
		</div>
		<div class="panel-footer">
			<div class="btn-toolbar">
				<a target="_blank" href="{{route('appanel.events.view', array('uid' => $event->uid))}}" class="btn btn-primary btn-sm" role="button">Información</a>
				<a target="_blank" href="{{route('home.event', array('uid' => $event->uid, 'void' => urlencode($event->title)))}}" class="btn btn-default btn-sm" role="button">Landing page</a>
				@if(Auth::user()->permissions()->events->edit)
				<a href="{{route('appanel.events.edit', array('uid' => $event->uid))}}" class="btn btn-default btn-sm" role="button">Editar</a>
				<a href="{{route('appanel.events.addhour', array('uid' => $event->uid))}}" class="btn btn-default btn-sm" role="button">Extender 1hr</a>
				<a href="{{route('appanel.events.finish', array('uid' => $event->uid))}}" class="btn btn-danger btn-sm" role="button">Terminar</a>
				@endif
			</div>
		</div>
	</div>
	@endif

	<div id="channel_info">
		<div class="row">



			@if($channel->online != 0)
			<div class="col-lg-4 col-md-6 col-sm-5 col-xs-12">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">En vivo ahora</h3>
					</div>
						<div class="embed-responsive embed-responsive-16by9">
							<iframe id="player" src="{{route('player.channel', array('uid' => $channel->uid))}}?muted" frameborder="0" allowfullscreen="true"></iframe>
						</div>
					<div class="panel-footer">
							<span class="label label-success">Online</span>
							<code>Transmitiendo indefinidamente</span></code>
					</div>
				</div>
			</div>
			@endif

			<div class="col-lg-8 col-md-6 col-sm-7 col-xs-12">
				<h5>Información RTMP</h5>
				<blockquote style="font-size: 1em;">
					<dl class="dl-horizontal">
						<dt>Código</dt>
						<dd><code>{{$channel->rtmp}}</code></dd>
					</dl>
					<dl class="dl-horizontal">
						<dt>Stream</dt>
						<dd><code>{{$channel->rtmp_stream}}</code></dd>
					</dl>
					<dl class="dl-horizontal">
						<dt>Usuario</dt>
						<dd><code>{{$channel->rtmp_user}}</code></dd>
					</dl>
					<dl class="dl-horizontal">
						<dt>Contraseña</dt>
						<dd><code>{{$channel->rtmp_pass}}</code></dd>
					</dl>
				</blockquote>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<h5>Enlace a la plataforma</h5>
				<pre><a target="_blank" href="{{URL::asset('/channel/' . $channel->uid . '/' . urlencode($channel->name))}}">{{URL::asset('/channel/' . $channel->uid . '/' . urlencode($channel->name))}}</a></pre>
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
&lt;amb:video uid="{{$channel->uid}}" type="channel"&gt;&lt;/amb:video&gt;</pre>
				</div>
			</div>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">Eventos</div>
		<table class="table table-hover">
			<thead>
				<tr>
					<th data-field="uid" style="text-align: left;">uid</th>
					<th data-field="name" style="text-align: left;">Nombre</th>
					<th data-field="date" style="text-align: left;">Fecha</th>
					<th data-field="tools"></th>
				</tr>
			</thead>
			<tbody>
			@foreach($channel->events as $c)
				<tr>
					<td>{{$c->uid}}</td>
					<td>{{$c->title}}</td>
					<td>{{$c->start_date_human()}} - {{$c->ended_date_human()}}</td>
					<td class="tools">
						<a title="Ver" href="{{route('appanel.events.view', array('uid' => $c->uid))}}" class="btn-icon">
							<i class="icon-visibility"></i>
						</a>
						@if(Auth::user()->permissions()->events->edit)
						<a title="Editar" href="{{route('appanel.events.edit', array('uid' => $c->uid))}}" class="btn-icon">
							<i class="icon-create"></i>
						</a>
						@endif
						@if(Auth::user()->permissions()->events->delete)
						<a title="Eliminar" href="{{route('appanel.events.delete', array('uid' => $c->uid))}}" class="btn-icon red">
							<i class="icon-delete"></i>
						</a>
						@endif
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
@stop