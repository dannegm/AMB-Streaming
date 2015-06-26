@extends('appanel/template')

@section('styles')
	<link rel="stylesheet" type="text/css" href="{{URL::asset('/panel/css/redactor.css')}}">
@stop
@section('scripts')
	<link rel="stylesheet" href="{{URL::asset('/panel/css/bootstrap-switch.min.css')}}">
	<script src="{{URL::asset('/panel/js/bootstrap-switch.min.js')}}"></script>

	<script src="{{URL::asset('/panel/js/fontsize.min.js')}}"></script>
	<script src="{{URL::asset('/panel/js/fullscreen.min.js')}}"></script>
	<script src="{{URL::asset('/panel/js/redactor.min.js')}}"></script>
	<script src="{{URL::asset('/panel/js/dnn.upload.js')}}"></script>
	<script>
	// Redactor
	$(document).ready(function(){
		$('#description').redactor({
			buttons: ['bold', 'italic', 'deleted', 'link'],
			convertLinks: true,
			minHeight: 150
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
	});

	</script>
@stop
@section('content')

	<ol class="breadcrumb">
		<li><a href="{{route('appanel')}}">Inicio</a></li>
		<li><a href="{{route('appanel.channels.index')}}">Canales</a></li>
		<li>Editar</li>
		<li class="active">{{$channel->name}}</li>
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
	{{Form::model($channel, array('route' => array('appanel.channels.update', $channel->uid), 'method' => 'PUT'))}}
		<div class="form-group">
			<label>Nombre</label>
			<input class="form-control input-lg" type="text" name="name" placeholder="Nombre del canal" value="{{$channel->name}}">
		</div>
		<div class="form-group">
			<label>Hacer visible el canal</label>
			<br />
			<input type="checkbox" name="visible"{{$channel->visible != 0 ? ' checked' : ''}} />
		</div>
		<div class="form-group">
			<textarea id="description" name="description" placeholder="Descripción">{{$channel->description}}</textarea>
		</div>

		<div class="form-group">
			<label>Canal RTMP</label>
			<div class="row">
				<div class="col-xs-6">
					<input class="form-control" type="text" name="rtmp" placeholder="rtmp://" value="{{$channel->rtmp}}">
				</div>
				<div class="col-xs-2">
					<input class="form-control" type="text" name="rtmp_stream" placeholder="stream" value="{{$channel->rtmp_stream}}">
				</div>
				<div class="col-xs-2">
					<input class="form-control" type="text" name="rtmp_user" placeholder="user" value="{{$channel->rtmp_user}}">
				</div>
				<div class="col-xs-2">
					<input class="form-control" type="text" name="rtmp_pass" placeholder="password" value="{{$channel->rtmp_pass}}">
				</div>
			</div>
		</div>
		<div class="form-group" style="border-top: 1px solid #eee; margin-top: 20px; padding-top: 20px;">
			<div class="row">
				<div class="col-xs-4">
					<label>Logo del canal</label>
					<input type="hidden" id="pic_logo" name="pic_logo" value="{{$channel->logo_uid}}" />
					<input type="file" id="file_logo" name="file_logo" />
					<img id="img_logo" src="{{URL::asset('/pictures/small/' . $channel->logo->url)}}" class="img-responsive img-rounded">
				</div>
				<div class="col-xs-4">
					<label>Portada del canal</label>
					<input type="hidden" id="pic_cover" name="pic_cover" value="{{$channel->cover_uid}}" />
					<input type="file" id="file_cover" name="file_cover" />
					<img id="img_cover" src="{{URL::asset('/pictures/small/' . $channel->cover->url)}}" class="img-responsive img-rounded">
				</div>
				<div class="col-xs-4">
					<label>Fondo del canal</label>
					<input type="hidden" id="pic_back" name="pic_back" value="{{$channel->background_uid}}" />
					<input type="file" id="file_back" name="file_back" />
					<img id="img_back" src="{{URL::asset('/pictures/small/' . $channel->background->url)}}" class="img-responsive img-rounded">
				</div>
			</div>
		</div>

		<div class="form-group" style="border-top: 1px solid #eee; margin-top: 20px; padding-top: 20px;">
			<button class="btn btn-primary" type="submit">Guardar</button>
			<a href="{{route('appanel.channels.index')}}" class="btn btn-default" role="button">Cancelar</a>
		</div>
	{{Form::close()}}
@stop