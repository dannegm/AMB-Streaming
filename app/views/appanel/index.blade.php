@extends('appanel/template')

@section('content')
	<ol class="breadcrumb">
		<li class="active">Inicio</li>
	</ol>

	<div class="btn-toolbar" style="margin-bottom: 1em;">
		@if(Auth::user()->permissions()->channels->create)
		<a href="channels/create" class="btn btn-default" role="button">Nuevo canal</a>
		@endif
		@if(Auth::user()->permissions()->events->create)
		<a href="events/create" class="btn btn-default" role="button">Nuevo evento</a>
		@endif
		@if(Auth::user()->permissions()->users->create)
		<a href="user/create" class="btn btn-default" role="button">Nuevo usuario</a>
		@endif
	</div>

	<div class="page-header">
		<h3>Últimos eventos</h3>
	</div>
	<div class="row">
	@foreach($events as $event)
		@if($event->isLive())
		<div class="col-md-12">
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
						<a href="{{route('appanel.events.view', array('uid' => $event->uid))}}" class="btn btn-primary btn-sm" role="button">Información</a>
						<a target="_blank" href="{{route('home.event', array('uid' => $event->uid, 'void' => urlencode($event->title)))}}" class="btn btn-default btn-sm" role="button">Landing page</a>
						@if(Auth::user()->permissions()->events->edit)
						<a href="{{route('appanel.events.edit', array('uid' => $event->uid))}}" class="btn btn-default btn-sm" role="button">Editar</a>
						<a href="{{route('appanel.events.addhour', array('uid' => $event->uid))}}" class="btn btn-default btn-sm" role="button">Extender 1hr</a>
						@endif
					</div>
				</div>
			</div>
		</div>
		@else
		<div class="col-md-3 col-sm-6">
			<div class="panel panel-default">
				<div class="panel-heading">{{$event->title}}</div>

				<img class="img-responsive" src="{{URL::asset('/pictures/small/' . $event->cover->url)}}">
				<div class="panel-body">
					<p>{{$event->start_date_human()}}</p>
					<p>{{$event->subtitle}}</p>
				</div>
				<div class="panel-body">
						<a href="{{route('appanel.events.view', array('uid' => $event->uid))}}" class="btn btn-default btn-sm" role="button">Información</a>
						@if(Auth::user()->permissions()->events->edit)
						<a href="{{route('appanel.events.edit', array('uid' => $event->uid))}}" class="btn btn-default btn-sm" role="button">Editar</a>
						@endif
				</div>
			</div>
		</div>
		@endif
	@endforeach
	</div>

@stop






