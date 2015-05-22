@extends('appanel/template')
@section('content')
<main>
	<!-- Header -->
	<nav id="top" class="top-nav">
		<span class="page-title">{{$title}}</span>
	</nav>

	<div class="container">

		<!-- Manejo de errores -->
		@if ($errors->has())
			<?php $dis = '' ?>
			@foreach ($errors->all() as $error)
				<?php $dis .= $error.'</br>' ?>
			@endforeach
			<script>
			$(window).load(function(){
				swal({
					title: 'Verfica lo siguiente',
					html: '{{$dis}}',
					type:'error',
				});
			});
			</script>
		@endif
		<!-- Manejo de errores -->
	
		<!-- Formulario -->
		{{Form::model($user, array('route' => array('appanel.user.update', $user->id), 'method' => 'PUT'))}}
			<div class="row">
				<div class="input-field col s12 big">
					<label>Nombre</label>
					<input type="text" name="name" class="form-control" value="{{$user->name}}">
				</div>
			</div>
			<div class="row">
				<div class="input-field col s12">
					<label>Username</label>
					<input type="text" name="username" value="{{$user->username}}" class="form-control">
				</div>
			</div>
			<div class="row">
				<div class="input-field col s12">
					<label>Email</label>
					<input type="text" name="email" class="form-control" value="{{$user->email}}">
				</div>
			</div>
			<div class="row">
				<div class="input-field col s12">
					<label>Nueva Contraseña</label>
					<input type="password" name="password" class="form-control" value="">
				</div>
			</div>
			<div class="row">
				<div class="input-fiel col s12">
					<button class="btn waves-effect waves-light right">Actualizar</button>
					<a href="{{route('appanel.user.destroy', array('id' => $user->id))}}" class="delete waves-effect waves-teal btn-flat">Borrar</a>
				</div>
			</div>
		{{Form::close()}}
	</div>

	<!-- Footer -->
	<footer id="footer" class="page-footer blue-grey darken-2">
		<div class="row">
			<div class="col l6 s12">
			</div>
		</div>
		<div class="footer-copyright">
			<div class="row">
				<div class="col s12">
					<span>© 2015 AMB Multimedia</span>
				</div>
			</div>
		</div>
	</footer>

</main>
@stop