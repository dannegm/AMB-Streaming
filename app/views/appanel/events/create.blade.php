@extends('appanel/template')

@section('styles')
	<link rel="stylesheet" type="text/css" href="{{URL::asset('/panel/css/redactor.css')}}">
	<link rel="stylesheet" type="text/css" href="{{URL::asset('/panel/css/jquery.datetimepicker.css')}}">
@stop
@section('scripts')
	<script src="{{URL::asset('/panel/js/fontsize.min.js')}}"></script>
	<script src="{{URL::asset('/panel/js/fullscreen.min.js')}}"></script>
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
	        $('#img_logo').attr('src', response.pic).fadeIn();
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
	        $('#img_cover').attr('src', response.pic).fadeIn();
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
	        $('#droppeable_back .options').hide();
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
	        $('#img_back').attr('src', response.pic).fadeIn();
	    }
	};

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
		<li class="active">Nuevo</li>
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
	{{Form::open(array('url' => route('appanel.events.store')))}}
		<div class="form-group">
				<label>Nombre del evento</label>
				<input class="form-control input-lg" type="text" name="title" placeholder="Nombre del evento" value="{{Input::old('title')}}">
		</div>
		<div class="form-group">
				<label>Despripción pequeña</label>
				<textarea id="subtitle" name="subtitle">{{Input::old('subtitle')}}</textarea>
		</div>
		<div class="form-group">
				<label>Descripción extensa</label>
				<textarea id="description" name="description">{{Input::old('description')}}</textarea>
		</div>

		<div class="form-group" style="border-top: 1px solid #eee; border-bottom: 1px solid #eee; margin: 20px 0; padding: 20px 0;">
			<div class="row">
				<div class="col-xs-4">
					<label>Logo del evento</label>
					<input type="hidden" id="pic_logo" name="pic_logo" />
					<input type="file" id="file_logo" name="file_logo" />
					<img id="img_logo" src="#" style="display: none;" class="img-responsive img-rounded">
				</div>
				<div class="col-xs-4">
					<label>Portada del evento</label>
					<input type="hidden" id="pic_cover" name="pic_cover" />
					<input type="file" id="file_cover" name="file_cover" />
					<img id="img_cover" src="#" style="display: none;" class="img-responsive img-rounded">
				</div>
				<div class="col-xs-4">
					<label>Fondo del evento</label>
					<input type="hidden" id="pic_back" name="pic_back" />
					<input type="file" id="file_back" name="file_back" />
					<img id="img_back" src="#" style="display: none;" class="img-responsive img-rounded">
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
							<option value="{{$c->uid}}">{{$c->name}}</option>
						@endforeach

					</select>
				</div>
				<div class="col-xs-6">
					<label>Nombre del Lugar</label>
					<input class="form-control" type="text" name="locale" placeholder="ej. Bellas Artes" value="{{Input::old('locale')}}" />
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="row">
				<div class="col-xs-6">
					<label>Inicia</label>
					<input class="form-control datetimepicker" type="date" name="started_at" value="{{Input::old('started_at')}}">
				</div>
				<div class="col-xs-6">
					<label>Termina</label>
					<input class="form-control datetimepicker" type="date" name="ended_at" value="{{Input::old('ended_at')}}">
				</div>
			</div>
		</div>

		<div class="form-group" style="border-top: 1px solid #eee; margin-top: 20px; padding-top: 20px;">
			<button class="btn btn-primary" type="submit">Añadir</button>
			<a href="{{route('appanel.events.index')}}" class="btn btn-default" role="button">Cancelar</a>
		</div>
	{{Form::close()}}
@stop