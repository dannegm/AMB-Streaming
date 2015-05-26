@extends('appanel/template')
@section('content')
	<!-- Header -->
	<nav id="toolbar">
		<a href="events/create" class="btn">Nuevo</a>
	</nav>

	<div class="container">
		<table class="w100p">
			<thead>
				<tr>
					<th data-field="id">#</th>
					<th data-field="uid">uid</th>
					<th data-field="name">Canal</th>
					<th data-field="name">Nombre</th>
					<th data-field="description">Descripción</th>
					<th data-field="started_at">Inicia</th>
					<th data-field="ended_at">Termina</th>
					<th data-field="tools"></th>
				</tr>
			</thead>
			<tbody>
			@foreach($events as $c)
				<tr>
					<td>{{$c->id}}</td>
					<td>{{$c->uid}}</td>
					<td>{{$c->channel->name}}</pre></td>
					<td>{{$c->title}}</td>
					<td>{{$c->subtitle}}</td>
					<td>{{$c->started_at}}</td>
					<td>{{$c->ended_at}}</td>
					<td class="tools">
						<a title="Ver" href="events/{{$c->uid}}/view" class="btn-icon">
							<i class="icon-visibility"></i>
						</a>
						<a title="Editar" href="events/{{$c->uid}}/edit" class="btn-icon">
							<i class="icon-create"></i>
						</a>
						<a title="Eliminar" href="events/{{$c->uid}}/delete" class="btn-icon red">
							<i class="icon-delete"></i>
						</a>
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
@stop