@extends('appanel/template')
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
				<div class="input-field col s12 big">
					<label>Nombre</label>
					<input type="text" name="name" value="{{Input::old('name')}}">
				</div>
			</div>
			<div class="row">
				<div class="input-field col s12">
					<label>Descripción</label>
					<textarea name="description" >{{Input::old('description')}}</textarea>
				</div>
			</div>
			<div class="row">
				<div class="input-field col s12">
					<label>Canal RTMP</label>
					<input type="text" name="rtmp" value="{{Input::old('rtmp')}}">
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