@extends('appanel/template')

@section('styles')
	<link rel="stylesheet" type="text/css" href="{{URL::asset('/panel/css/redactor.css')}}">
	<link rel="stylesheet" type="text/css" href="{{URL::asset('/panel/css/jquery.datetimepicker.css')}}">
@stop
@section('scripts')
	<link rel="stylesheet" href="{{URL::asset('/panel/css/bootstrap-switch.min.css')}}">
	<script src="{{URL::asset('/panel/js/bootstrap-switch.min.js')}}"></script>

	<script src="{{URL::asset('/panel/js/fontsize.min.js')}}"></script>
	<script src="{{URL::asset('/panel/js/fullscreen.min.js')}}"></script>
	<script src="{{URL::asset('/panel/js/blockquote.js')}}"></script>
	<script src="{{URL::asset('/panel/js/redactor.min.js')}}"></script>
	<script src="{{URL::asset('/panel/js/jquery.datetimepicker.js')}}"></script>
	<script src="{{URL::asset('/panel/js/dnn.upload.js')}}"></script>
	<script>
	// Redactor
	$(document).ready(function(){
		$('#subtitle').redactor({
			buttons: ['bold', 'italic', 'deleted', 'link'],
			convertLinks: true,
			minHeight: 50
		});
		$('#description').redactor({
			plugins: ['fontsize','fullscreen'],
			convertVideoLinks: true,
			convertLinks: true,
			toolbarFixedBox: true,
			minHeight: 150,
			imageUpload: '{{route('appanel.picture.upload')}}',
			imageGetJson: '{{URL::asset('/appanel/pictures/all.json')}}',
			clipboardUploadUrl: '{{route('appanel.picture.upload')}}'
		});
	});

	// Upload
	var pictureAPI = "{{route('appanel.picture.upload')}}";

	var options_logo = {
	    url: pictureAPI,
	    filename: 'file',
	    group: 'Logo',
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
	        $('#pic_logo').val(response.id);
	        $('#img_logo').attr('src', response.pic);
	    }
	};
	var options_cover = {
	    url: pictureAPI,
	    filename: 'file',
	    group: 'Cover',
	    maxSize: 8 * 1024 * 1024,
	    maxWidth: 2048,
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
	        $('#pic_cover').val(response.id);
	        $('#img_cover').attr('src', response.pic);
	    }
	};
	var options_back = {
	    url: pictureAPI,
	    filename: 'file',
	    group: 'Background',
	    maxSize: 8 * 1024 * 1024,
	    maxWidth: 2048,
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
	        $('#pic_back').val(response.id);
	        $('#img_back').attr('src', response.pic);
	    }
	};

	$.fn.bootstrapSwitch.defaults.size = 'mini';
	$(function () {
	    // Logo
	    $('#file_logo').on('change', function (e) {
	        e.preventDefault();
	        options_logo.files = this.files;
	        upload( options_logo );
	    });

	    // Cover
	    $('#file_cover').on('change', function (e) {
	        e.preventDefault();
	        options_cover.files = this.files;
	        upload( options_cover );
	    });

	    // Background
	    $('#file_back').on('change', function (e) {
	        e.preventDefault();
	        options_back.files = this.files;
	        upload( options_back );
	    });

	    // Switches
	    $('[type="checkbox"]').bootstrapSwitch();

	    $('#is_w_number').on('switchChange.bootstrapSwitch', function(event, state) {
	    	if (state) {
	    		$('#nrecord').val('1');
	    		$('#nrecord_field').show();
	    	} else {
	    		$('#nrecord').val('0');
	    		$('#nrecord_field').hide();
	    	}
		});
	});

	// Datepicker
	$(function () {
		$('.datetimepicker').attr('type', 'text')
			.datetimepicker({
				format: 'Y-m-d H:i',
				mask: true,
				lang: 'es'
			});
	});

	</script>
@stop
@section('content')

	<ol class="breadcrumb">
		<li><a href="{{route('appanel')}}">Inicio</a></li>
		<li><a href="{{route('appanel.events.index')}}">Eventos</a></li>
		<li>Editar</li>
		<li class="active">{{$event->title}}</li>
	</ol>

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
	{{Form::model($event, array('route' => array('appanel.events.update', $event->uid), 'method' => 'PUT'))}}

		@if($event->nrecord != 0)
		<div class="form-group">
			<div class="alert alert-info" role="alert">Estás editando el evento <span class="label label-info">#{{$event->nrecord}}</span> de <b>{{$event->title}}</b></div>
		</div>
		@endif

		<div class="form-group">
				<label>Nombre del evento</label>
				<input class="form-control input-lg" type="text" name="title" placeholder="Nombre del evento" value="{{$event->title}}">
		</div>
		<div class="form-group">
			<div class="row">
				<div class="col-xs-6">
					<label>RTMP de respaldo</label>
					<input class="form-control" type="rtmp" name="rtmp" placeholder="rtmp://" value="{{$event->rtmp}}">
					<span id="helpBlock" class="help-block">Código RTMP de la grabación del evento, dejar en blanco para desactivar esta opción.</span>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="row">
				<div class="col-xs-12">
					<label>Información FTP</label>
					<div class="row">
						<div class="col-xs-3">
							<input class="form-control" type="ftp_host" name="ftp_host" placeholder="ftp://" value="{{$event->ftp_host}}">
							<span id="helpBlock" class="help-block">Host</span>
						</div>
						<div class="col-xs-3">
							<input class="form-control" type="ftp_port" name="ftp_port" placeholder="21" value="{{$event->ftp_port}}">
							<span id="helpBlock" class="help-block">Puerto</span>
						</div>
						<div class="col-xs-3">
							<input class="form-control" type="ftp_user" name="ftp_user" value="{{$event->ftp_user}}">
							<span id="helpBlock" class="help-block">Usuario</span>
						</div>
						<div class="col-xs-3">
							<input class="form-control" type="ftp_pass" name="ftp_pass" value="{{$event->ftp_pass}}">
							<span id="helpBlock" class="help-block">Contraseña</span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
				<label>Despripción pequeña</label>
				<textarea id="subtitle" name="subtitle">{{$event->subtitle}}</textarea>
		</div>
		<div class="form-group">
				<label>Descripción extensa</label>
				<textarea id="description" name="description">{{$event->description}}</textarea>
		</div>

		<div class="form-group" style="border-top: 1px solid #eee; margin-top: 20px; padding-top: 20px;">
			<div class="row">
				<div class="col-xs-6">
					<label>Número secuencial de evento</label>
					<div class="row">
						<div class="col-xs-4 col-sm-3 col-md-2" style="margin-top: 6px;">
							<input type="checkbox" id="is_w_number"{{$event->nrecord != 0 ? ' checked' : ''}} />
						</div>
						<div class="col-xs-6 col-sm-6 col-md-3" id="nrecord_field"{{$event->nrecord != 0 ? '' : ' style="display:none;"'}}>
							<div class="input-group">
								<div class="input-group-addon">#</div>
								<input class="form-control" id="nrecord" type="nrecord" name="nrecord" placeholder="#secuencia" value="{{$event->nrecord}}">
							</div>
						</div>
					</div>
				</div>
				<div class="col-xs-6">
					<label>Tema del landing page</label>
					<select name="theme" class="form-control">
						<option value="normal"{{$event->theme == 'normal' ? ' selected' : ''}}>Por defecto</option>
						<option value="blank"{{$event->theme == 'blank' ? ' selected' : ''}}>Fondo con tonos claros</option>
					</select>
				</div>
			</div>
		</div>

		<div class="form-group" style="border-top: 1px solid #eee; border-bottom: 1px solid #eee; margin: 20px 0; padding: 20px 0;">
			<div class="row">
				<div class="col-xs-4">
					<label>Logo del evento</label>
					<input type="hidden" id="pic_logo" name="pic_logo" value="{{$event->logo_uid}}" />
					<input type="file" id="file_logo" name="file_logo" />
					<img id="img_logo" src="{{URL::asset('/pictures/small/' . $event->logo->url)}}" class="img-responsive img-rounded">
				</div>
				<div class="col-xs-4">
					<label>Portada del evento</label>
					<input type="hidden" id="pic_cover" name="pic_cover" value="{{$event->cover_uid}}" />
					<input type="file" id="file_cover" name="file_cover" />
					<img id="img_cover" src="{{URL::asset('/pictures/small/' . $event->cover->url)}}" class="img-responsive img-rounded">
				</div>
				<div class="col-xs-4">
					<label>Fondo del evento</label>
					<input type="hidden" id="pic_back" name="pic_back" value="{{$event->background_uid}}" />
					<input type="file" id="file_back" name="file_back" />
					<img id="img_back" src="{{URL::asset('/pictures/small/' . $event->background->url)}}" class="img-responsive img-rounded">
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="row">
				<div class="col-xs-6">
					<label>Canal asociado</label>
					<select name="channel" class="form-control">
						<option value="" disabled selected>Selecciona un canal</option>

						@foreach($channels as $c)
							<option value="{{$c->uid}}"{{$event->channel_uid == $c->uid ? ' selected' : ''}}>{{$c->name}}</option>
						@endforeach

					</select>
				</div>
				<div class="col-xs-6">
					<label>Nombre del Lugar</label>
					<input class="form-control" type="text" name="locale" placeholder="ej. Bellas Artes" value="{{$event->locale}}" />
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="row">
				<div class="col-xs-6">
					<label>Inicia</label>
					<input class="form-control datetimepicker" type="date" name="started_at" value="{{$event->started_at}}">
				</div>
				<div class="col-xs-6">
					<label>Termina</label>
					<input class="form-control datetimepicker" type="date" name="ended_at" value="{{$event->ended_at}}">
				</div>
			</div>
		</div>

		<div class="form-group" style="border-top: 1px solid #eee; margin-top: 20px; padding-top: 20px;">
			<button class="btn btn-primary" type="submit">Guardar</button>
			<a href="{{route('appanel.events.index')}}" class="btn btn-default" role="button">Cancelar</a>
		</div>
	{{Form::close()}}
@stop