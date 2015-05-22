@extends('appanel/template')

@section('content')
<main>
	<!-- Header -->
	<nav id="top" class="top-nav">
		<span class="page-title">{{$title}}</span>
	</nav>
	<input type="file" id="file" class="hidden" />

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
	<h3>Crear un taller</h3>
	{{Form::open(array('url' => route('appanel.taller.store')))}}
		<div class="row">
			<div class="input-field col s12">
				<label>Título</label>
				<input type="text" id="title" name="title" value="{{Input::old('title')}}"/>
			</div>
		</div>

		<div class="row">
			<div class="col s12">
				<label>Contenido</label>
				<textarea name="contenido" id="content">{{Input::old('contenido')}}</textarea>
			</div>
		</div>

		<div class="row">
			<div class="input-field col s12">
				<button class="btn waves-effect waves-light right">Guardar</button>
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
<script>
	$(document).ready(function() {
		back = $('.urlcover').val();
		$('#droppeable').css({
			'background-image': "url('" + back + "')"
		});
	});
</script>
@stop