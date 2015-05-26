@extends('appanel/template')

@section('styles')
	<link rel="stylesheet" type="text/css" href="{{URL::asset('/panel/css/redactor.css')}}">
@stop
@section('scripts')
	<script src="{{URL::asset('/panel/js/fontsize.min.js')}}"></script>
	<script src="{{URL::asset('/panel/js/fullscreen.min.js')}}"></script>
	<script src="{{URL::asset('/panel/js/redactor.min.js')}}"></script>
	<script src="{{URL::asset('/panel/js/dnn.upload.js')}}"></script>
	<script>
	$(document).ready(function(){
		$('#description').redactor({
			buttons: ['bold', 'italic', 'deleted', 'link'],
			convertLinks: true,
			minHeight: 50
		});
	});
	</script>
@stop
@section('content')
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
		{{Form::open(array('url' => route('appanel.channels.store')))}}
			<div class="row">
				<div class="input-field big">
					<label>Nombre</label>
					<input type="text" name="name" placeholder="Nombre del canal" value="{{Input::old('name')}}">
				</div>
			</div>
			<div class="row">
				<div class="input-field">
					<textarea id="description" name="description" placeholder="Descripción">{{Input::old('description')}}</textarea>
				</div>
			</div>
			<div class="row">
				<div class="input-field w50">
					<label>Canal RTMP</label>
					<input type="text" name="rtmp" placeholder="rtmp://" value="{{Input::old('rtmp')}}">
				</div>
			</div>

			<div class="row">
				<div id="droppeable_logo" class="input-upload square">
					<input type="hidden" id="pic_logo" name="pic_logo" />
					<input type="file" id="file_logo" name="file_logo" />
					<div class="response">
						<div class="progress_back">
							<div class="progress_front"></div>
						</div>
					</div>
					<div class="options">
						<button class="openFile">Sube o Arrastra una imágen</button>
					</div>
				</div>

				<div id="droppeable_cover" class="input-upload landscape">
					<input type="hidden" id="pic_cover" name="pic_cover" />
					<input type="file" id="file_cover" name="file_cover" />
					<div class="response">
						<div class="progress_back">
							<div class="progress_front"></div>
						</div>
					</div>
					<div class="options">
						<button class="openFile">Sube o Arrastra una imágen</button>
					</div>
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