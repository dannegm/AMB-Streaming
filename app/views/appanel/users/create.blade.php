@extends('appanel/template')

@section('scripts')
	<link rel="stylesheet" href="{{URL::asset('/panel/css/bootstrap-switch.min.css')}}">
	<script src="{{URL::asset('/panel/js/bootstrap-switch.min.js')}}"></script>
	<script src="{{URL::asset('/panel/js/dnn.upload.js')}}"></script>
	<script>
	// Upload
	var pictureAPI = "{{route('appanel.picture.upload')}}";

	var options_avatar = {
	    url: pictureAPI,
	    filename: 'file',
	    group: 'UserProfile',
	    maxSize: 8 * 1024 * 1024,
	    maxWidth: 720,
	    start: function () {
	    },
	    process: function () {
	    },
	    error: function (error) {
	        console.log(error.message);
	    },
	    xhr: function () {
	        var xhr = new window.XMLHttpRequest();
	        xhr.upload.addEventListener('progress', function(p) {
	            var percentComplete = p.loaded / p.total;
	            var percent = parseFloat(Math.round((percentComplete * 100)));
	        }, false);
	        return xhr;
	    },
	    success: function (response) {
	        $('#pic_avatar').val(response.id);
	        $('#img_avatar').attr('src', response.pic).fadeIn();
	    }
	};

	$.fn.bootstrapSwitch.defaults.size = 'mini';
	$(function () {
	    // Logo
	    var input_avatar = $('#file_avatar');
	    input_avatar.on('change', function (e) {
	        e.preventDefault();
	        options_avatar.files = this.files;
	        upload( options_avatar );
	    });

	    // Switches
	    $('[type="checkbox"]').bootstrapSwitch();
	});

	</script>
@stop
@section('content')
	<ol class="breadcrumb">
		<li><a href="{{route('appanel')}}">Inicio</a></li>
		<li><a href="{{route('appanel.user.index')}}">Usuarios</a></li>
		<li class="active">Nuevo</li>
	</ol>

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
		<div class="col-md-6 col-xs-12">
			<div class="form-group">
				<label>Nombre</label>
				<input class="form-control input-lg" type="text" name="name" placeholder="Nombre" value="{{Input::old('name')}}">
			</div>
			<div class="form-group">
				<label>Username</label>
				<input class="form-control" type="text" name="username" placeholder="Nombre de usuario" value="{{Input::old('username')}}">
			</div>

			<div class="form-group" style="border-top: 1px solid #eee; border-bottom: 1px solid #eee; margin: 20px 0; padding: 20px 0;">
				<label>Foto de perfil</label>
				<div class="media">
					<div class="media-left media-top">
						<img id="img_avatar" src="http://video.ambmultimedia.mx/pictures/sqm/3d50e83f7586325304f88584f699ad33.png" class="img-rounded">
					</div>
					<div class="media-body">
						<br />
						<input type="hidden" id="pic_avatar" name="pic_avatar" />
						<input type="file" id="file_avatar" name="file_avatar" />
					</div>
				</div>
			</div>

			<div class="form-group">
				<label>Email</label>
				<input class="form-control" type="text" name="email" placeholder="email" value="{{Input::old('email')}}">

			</div>
			<div class="form-group">
				<label>Nueva Contraseña</label>
				<input class="form-control" type="password" name="password" placeholder="contraseña" value="">
			</div>


			<div class="form-group" style="border-top: 1px solid #eee; margin-top: 20px; padding-top: 20px;">
				<button class="btn btn-primary" type="submit">Añadir</button>
				<a href="{{route('appanel.events.index')}}" class="btn btn-default" role="button">Cancelar</a>
			</div>

		</div>

		<div class="col-md-6 col-xs-12">
			<h3>Permisos</h3>
			<div class="panel panel-default">
				<div class="panel-heading">Usuarios</div>
				<table class="table">
					<tr>
						<td>Crear</td>
						<td class="text-right"><input type="checkbox" name="permission_user_create" /></td>
					</tr>
					<tr>
						<td>Editar</td>
						<td class="text-right"><input type="checkbox" name="permission_user_edit" /></td>
					</tr>
					<tr>
						<td>Eliminar</td>
						<td class="text-right"><input type="checkbox" name="permission_user_delete" /></td>
					</tr>
				</table>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">Canales</div>
				<table class="table">
					<tr>
						<td>Crear</td>
						<td class="text-right"><input type="checkbox" name="permission_channel_create" /></td>
					</tr>
					<tr>
						<td>Editar</td>
						<td class="text-right"><input type="checkbox" name="permission_channel_edit" /></td>
					</tr>
					<tr>
						<td>Eliminar</td>
						<td class="text-right"><input type="checkbox" name="permission_channel_delete" /></td>
					</tr>
				</table>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">Eventos</div>
				<table class="table">
					<tr>
						<td>Crear</td>
						<td class="text-right"><input type="checkbox" name="permission_event_create" /></td>
					</tr>
					<tr>
						<td>Editar</td>
						<td class="text-right"><input type="checkbox" name="permission_event_edit" /></td>
					</tr>
					<tr>
						<td>Eliminar</td>
						<td class="text-right"><input type="checkbox" name="permission_event_delete" /></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	{{Form::close()}}
@stop