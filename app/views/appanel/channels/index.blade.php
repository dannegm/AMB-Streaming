@extends('appanel/template')
@section('content')
	<ol class="breadcrumb">
		<li><a href="{{route('appanel')}}">Inicio</a></li>
		<li class="active">Canales</li>
	</ol>
	<div class="btn-toolbar" style="margin-bottom: 1em;">
		@if(Auth::user()->permissions()->channels->create)
		<a href="channels/create" class="btn btn-default" role="button">Nuevo canal</a>
		@endif
	</div>

	<table class="table table-hover">
		<thead>
			<tr>
				<th data-field="uid" style="text-align: left;">uid</th>
				<th data-field="name" style="text-align: left;">Nombre</th>
				<th data-field="rtmp" style="text-align: left;">RTMP</th>
				<th data-field="tools"></th>
			</tr>
		</thead>
		<tbody>
		@foreach($channels as $c)
			<tr
			@if($c->has_live() != false)
			class="info"
			@endif
			>
				<td>
					@if($c->has_live() != false)
					<span class="label label-danger">En vivo</span>
					@endif
					<code>{{$c->uid}}</code>
				</td>
				<td>{{$c->name}}</td>
				<td>{{$c->rtmp}}</td>
				<td class="tools">
					<a title="Ver" href="channels/{{$c->uid}}/view" class="btn-icon">
						<i class="icon-visibility"></i>
					</a>
					@if(Auth::user()->permissions()->channels->edit)
					<a title="Editar" href="channels/{{$c->uid}}/edit" class="btn-icon">
						<i class="icon-create"></i>
					</a>
					@endif
					@if(Auth::user()->permissions()->channels->delete)
					<a title="Eliminar" href="channels/{{$c->uid}}/delete" class="btn-icon red">
						<i class="icon-delete"></i>
					</a>
					@endif
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
@stop