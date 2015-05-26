@extends('appanel/template')
@section('content')
	<!-- Header -->
	<nav id="toolbar">
		<a href="user/create" class="btn">Nuevo</a>
	</nav>

	<div class="container">
		<ul class="collection with-header">
		@foreach($users as $u)
			<li class="collection-item"><a href="user/{{$u->id}}/edit">{{$u->username}}</a></li>
		@endforeach
		</ul>
	</div>
@stop