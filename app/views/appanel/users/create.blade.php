@extends('appanel/template')
@section('content')
	<div class="container">
		<!-- Manejo de errores -->
		@if($errors->has())
			<?php $dis = '' ?>
			@foreach ($errors->all() as $error)
				<?php $dis .= $error . '</br>' ?>
			@endforeach
			<script>
			$(window).load(function(){
				swal({
					title: 'Verfica lo siguiente',
					html: '{{$dis}}',
					type:'error'
				});
			});
			</script>
		@endif
		<!-- Manejo de errores -->

		<!-- Formulario -->
		{{Form::open(array('url' => route('appanel.user.store')))}}
			<div class="row">
				<div class="input-field col s12 big">
					<label>Nombre</label>
					<input type="text" name="name" value="{{Input::old('name')}}">
				</div>
			</div>
			<div class="row">
				<div class="input-field col s12">
					<label>Username</label>
					<input type="text" name="username" value="{{Input::old('username')}}">
				</div>
			</div>
			<div class="row">
				<div class="input-field col s12">
					<label>Email</label>
					<input type="text" name="email" value="{{Input::old('email')}}">
				</div>
			</div>
			<div class="row">
				<div class="input-field col s12">
					<label>Nueva Contraseña</label>
					<input type="password" name="password" value="">
				</div>
			</div>
			<div class="row">
				<div class="input-fiel col s12">
					<button class="btn waves-effect waves-light right">Añadir</button>
				</div>
			</div>
		{{Form::close()}}
	</div>
@stop