@extends('appanel/template')
@section('content')
	<ol class="breadcrumb">
		<li><a href="{{route('appanel')}}">Inicio</a></li>
		<li class="active">Usuarios</li>
	</ol>
	<div class="btn-group" style="margin-bottom: 1em;">
		@if(Auth::user()->permissions()->users->create)
		<a href="user/create" class="btn btn-default" role="button">Nuevo usuario</a>
		@endif
	</div>

	<div class="row" style="margin-top: 2em;">
	@foreach($users as $u)
		<div class="col-md-3 col-sm-4 col-xs-6">
			<div class="media">
				<div class="media-left media-top">
					<img class="media-object img-circle" src="{{URL::asset('/pictures/sqm/' . $u->picture->url)}}">
				</div>
				<div class="media-body">
					<h4 class="media-heading">{{$u->name}}</h4>
					<p>
						<span class="username">{{"@" . $u->username}}</span><br />
						@if(Auth::user()->permissions()->users->create)
						<a href="user/{{$u->uid}}/edit" class="btn btn-link btn-xs">Editar</a>
						@else
						<a href="user/{{$u->uid}}/edit" class="btn btn-link btn-xs">Ver</a>
						@endif
					</p>
				</div>
			</div>
		</div>
	@endforeach
	</div>
@stop