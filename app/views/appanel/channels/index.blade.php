@extends('appanel/template')
@section('content')
	<!-- Header -->
	<nav id="toolbar">
		<a href="channels/create" class="btn">Nuevo</a>
	</nav>

	<div class="container">
		<table class="w100p">
			<thead>
				<tr>
					<th data-field="id">#</th>
					<th data-field="uid">uid</th>
					<th data-field="name">Nombre</th>
					<th data-field="description">Descripción</th>
					<th data-field="rtmp">RTMP</th>
					<th data-field="tools"></th>
				</tr>
			</thead>
			<tbody>
			@foreach($channels as $c)
				<tr>
					<td>{{$c->id}}</td>
					<td>{{$c->uid}}</td>
					<td>{{$c->name}}</td>
					<td>{{$c->description}}</td>
					<td>{{$c->rtmp}}</td>
					<td class="tools">
						<a title="Ver" href="channels/{{$c->uid}}/view" class="btn-icon">
							<i class="icon-visibility"></i>
						</a>
						<a title="Editar" href="channels/{{$c->uid}}/edit" class="btn-icon">
							<i class="icon-create"></i>
						</a>
						<a title="Eliminar" href="channels/{{$c->uid}}/delete" class="btn-icon red">
							<i class="icon-delete"></i>
						</a>
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
@stop