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
	        $('#droppeable_avatar .options').hide();
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
	        $('#img_avatar').attr('src', response.pic);
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
		<li>Editar</li>
		<li class="active">{{$user->name}}</li>
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

	{{Form::model($user, array('route' => array('appanel.user.update', $user->uid), 'method' => 'PUT'))}}
	<div class="row">
		<div class="col-md-6 col-xs-12">
		<!-- Formulario -->
			<div class="form-group">
				<label>Nombre</label>
				<input class="form-control input-lg" type="text" name="name" placeholder="Nombre" value="{{$user->name}}">
			</div>
			<div class="form-group">
				<label>Username</label>
				<input class="form-control" type="text" name="username" placeholder="Nombre de usuario" value="{{$user->username}}">
			</div>

			<div class="form-group" style="border-top: 1px solid #eee; border-bottom: 1px solid #eee; margin: 20px 0; padding: 20px 0;">
				<label>Foto de perfil</label>
				<div class="media">
					<div class="media-left media-top">
						<img id="img_avatar" src="{{URL::asset('/pictures/sqm/' . $user->picture->url)}}" class="img-rounded">
					</div>
					<div class="media-body">
						<br />
						<input type="hidden" id="pic_avatar" name="pic_avatar" value="{{$user->avatar}}" />
						<input type="file" id="file_avatar" name="file_avatar" />
					</div>
				</div>
			</div>

			<div class="form-group">
				<label>Email</label>
				<input class="form-control" type="text" name="email" placeholder="email" value="{{$user->email}}">

			</div>
			<div class="form-group">
				<label>Nueva Contraseña</label>
				<input class="form-control" type="password" name="password" placeholder="contraseña" value="">
			</div>


			@if(Auth::user()->uid != $user->uid)
			<div class="form-group" style="border-top: 1px solid #eee; margin-top: 20px; padding-top: 20px;">
				@if(Auth::user()->permissions()->users->edit)
				<button class="btn btn-primary" type="submit">Guardar</button>
				<a href="{{route('appanel.user.index')}}" class="btn btn-default" role="button">Cancelar</a>
				@else
				<a href="{{route('appanel.user.index')}}" class="btn btn-default" role="button">Regresar</a>
				@endif

				@if(Auth::user()->permissions()->users->delete)
				<a href="{{route('appanel.user.destroy', array('uid' => $user->uid))}}" class="btn btn-danger" role="button">Eliminar</a>
				@endif
			</div>
			@else
			<div class="form-group" style="border-top: 1px solid #eee; margin-top: 20px; padding-top: 20px;">
				<button class="btn btn-primary" type="submit">Guardar</button>
				<a href="{{route('appanel.user.index')}}" class="btn btn-default" role="button">Cancelar</a>
			</div>
			@endif

		</div>

		<?php $permissions = $user->permissions(); ?>
		<div class="col-md-6 col-xs-12"{{ Auth::user()->permissions()->users->edit ? '' : ' style="display: none;"'}}>
			<h3>Permisos</h3>
			<div class="panel panel-default">
				<div class="panel-heading">Usuarios</div>
				<table class="table">
					<tr>
						<td>Crear</td>
						<td class="text-right"><input type="checkbox" name="permission_user_create"{{ $permissions->users->create ? ' checked' : '' }}{{ Auth::user()->permissions()->users->edit ? '' : ' disabled'}} /></td>
					</tr>
					<tr>
						<td>Editar</td>
						<td class="text-right"><input type="checkbox" name="permission_user_edit"{{ $permissions->users->edit ? ' checked' : '' }}{{ Auth::user()->permissions()->users->edit ? '' : ' disabled'}} /></td>
					</tr>
					<tr>
						<td>Eliminar</td>
						<td class="text-right"><input type="checkbox" name="permission_user_delete"{{ $permissions->users->delete ? ' checked' : '' }}{{ Auth::user()->permissions()->users->edit ? '' : ' disabled'}} /></td>
					</tr>
				</table>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">Canales</div>
				<table class="table">
					<tr>
						<td>Crear</td>
						<td class="text-right"><input type="checkbox" name="permission_channel_create"{{ $permissions->channels->create ? ' checked' : '' }}{{ Auth::user()->permissions()->users->edit ? '' : ' disabled'}} /></td>
					</tr>
					<tr>
						<td>Editar</td>
						<td class="text-right"><input type="checkbox" name="permission_channel_edit"{{ $permissions->channels->edit ? ' checked' : '' }}{{ Auth::user()->permissions()->users->edit ? '' : ' disabled'}} /></td>
					</tr>
					<tr>
						<td>Eliminar</td>
						<td class="text-right"><input type="checkbox" name="permission_channel_delete"{{ $permissions->channels->delete ? ' checked' : '' }}{{ Auth::user()->permissions()->users->edit ? '' : ' disabled'}} /></td>
					</tr>
				</table>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">Eventos</div>
				<table class="table">
					<tr>
						<td>Crear</td>
						<td class="text-right"><input type="checkbox" name="permission_event_create"{{ $permissions->events->create ? ' checked' : '' }}{{ Auth::user()->permissions()->users->edit ? '' : ' disabled'}} /></td>
					</tr>
					<tr>
						<td>Editar</td>
						<td class="text-right"><input type="checkbox" name="permission_event_edit"{{ $permissions->events->edit ? ' checked' : '' }}{{ Auth::user()->permissions()->users->edit ? '' : ' disabled'}} /></td>
					</tr>
					<tr>
						<td>Eliminar</td>
						<td class="text-right"><input type="checkbox" name="permission_event_delete"{{ $permissions->events->delete ? ' checked' : '' }}{{ Auth::user()->permissions()->users->edit ? '' : ' disabled'}} /></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	{{Form::close()}}
@stop







