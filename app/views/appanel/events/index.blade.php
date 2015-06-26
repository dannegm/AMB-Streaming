@extends('appanel/template')
@section('content')
	<ol class="breadcrumb">
		<li><a href="{{route('appanel')}}">Inicio</a></li>
		<li class="active">Eventos</li>
	</ol>
	<div class="btn-toolbar" style="margin-bottom: 1em;">
		@if(Auth::user()->permissions()->events->create)
		<a href="events/create" class="btn btn-default" role="button">Nuevo evento</a>
		@endif
	</div>

	<table class="table table-hover">
		<thead>
			<tr>
				<th data-field="marker"></th>
				<th data-field="uid" style="text-align: left;">uid</th>
				<th data-field="name" style="text-align: left;">Canal</th>
				<th data-field="name" style="text-align: left;">Nombre</th>
				<th data-field="date" style="text-align: left;" class="hidden-sm">Fecha</th>
				<th data-field="tools"></th>
			</tr>
		</thead>
		<tbody>
		@foreach($events as $c)
			<tr
			@if($c->isLive() != false)
			class="info"
			@endif
			>
				<td>
					@if($c->marked != 0)
					<a class="btn btn-link" href="{{route('appanel.events.unmark', array('uid' => $c->uid))}}" role="button">
						<span class="glyphicon glyphicon-star" aria-hidden="true"></span>
					</a>
					@else
					<a class="btn btn-link" href="{{route('appanel.events.mark', array('uid' => $c->uid))}}" role="button">
						<span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span>
					</a>
					@endif
				</td>
				<td>
					@if($c->isLive())
					<span class="label label-danger">En vivo</span>
					@endif
					@if(!empty($c->rtmp))
					<span class="label label-info">REC</span>
					@endif
					<code>{{$c->uid}}</code>
				</td>
				<td>{{$c->channel->name}}</pre></td>
				<td>
					{{$c->title}}
					@if($c->nrecord != 0)
						<span class="label label-default">#{{$c->nrecord}}</span>
					@endif
				</td>
				<td class="hidden-sm">{{$c->start_date_human()}} - {{$c->ended_date_human()}}</td>
				<td class="tools">
					<a title="Ver" href="events/{{$c->uid}}/view" class="btn-icon">
						<i class="icon-visibility"></i>
					</a>
					@if(Auth::user()->permissions()->events->edit)
					<a title="Editar" href="events/{{$c->uid}}/edit" class="btn-icon">
						<i class="icon-create"></i>
					</a>
					@endif
					@if(Auth::user()->permissions()->events->delete)
					<a title="Eliminar" href="events/{{$c->uid}}/delete" class="btn-icon red">
						<i class="icon-delete"></i>
					</a>
					@endif
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
@stop