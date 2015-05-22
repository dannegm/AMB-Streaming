@extends('appanel/template')

@section('scripts')
	<script src="{{URL::asset('/panel/js/dnn.upload.js')}}"></script>
@stop

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

	@if(empty($taller->imgsrc))
		<script>
		$(window).load(function(){
			swal({
				title: 'Advertencia',
				html: 'Coloca una imagen al taller o este no se verá en la app, también debes colocar los horarios',
				type:'warning',
			});
		});
		</script>
	@endif
	<!-- Manejo de errores -->
	
	<!-- Formulario -->
	{{Form::model($taller, array('route' => array('appanel.taller.update', $taller->id), 'method' => 'PUT'))}}
		<div class="row">
			<div class="input-field col s12">
				@if(empty($taller->imgsrc))
					<div id="droppeable" class="card-panel grey lighten-5 z-depth-1 upload" style="height: 200px;">
				@else
					<div id="droppeable" class="card-panel grey lighten-5 z-depth-1 upload" style="height: 200px;background: url({{$taller->imgsrc}}); background-size:cover !important; background-position:center">
				@endif
					<input type="hidden" class="pic" name="cover" value="{{Input::old('cover')}}" />
					<input type="hidden" class="urlcover" name="urlcover" value="{{Input::old('urlcover')}}" />
					<div class="response">
						<div class="progress">
							<div id="uploadStatus" class="determinate" style="width: 70%"></div>
						</div>
					</div>
					<div class="options">
						<button id="ajaxdrop" data-upload="{{route('upload.taller', array('id' => $taller->id))}}" class="openFile btn col s10 offset-s1">Sube o arrastra una imágen</button>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="input-field col s12">
				<label>Título</label>
				<input type="text" id="title" name="title" value="{{$taller->title}}"/>
			</div>
		</div>

		<div class="row">
			<div class="col s12">
				<label>Contenido</label>
				<textarea name="contenido" id="content">{{$taller->content}}</textarea>
			</div>
		</div>

		<h5>Horarios</h5>
		<div class="horarios">
			<?php
				if( !empty($horarios[0]->horario) ){
					$horario1 = $horarios[0]->horario;
				}else{
					$horario1 = '';
				}

				if( !empty($horarios[1]->horario) ){
					$horario2 = $horarios[1]->horario;
				}else{
					$horario2 = '';
				}

				if( !empty($horarios[2]->horario) ){
					$horario3 = $horarios[2]->horario;
				}else{
					$horario3 = '';
				}

				if( !empty($horarios[3]->horario) ){
					$horario4 = $horarios[3]->horario;
				}else{
					$horario4 = '';
				}

				if( !empty($horarios[4]->horario) ){
					$horario5 = $horarios[4]->horario;
				}else{
					$horario5 = '';
				}
			?>
			<input type="text" name="horario1" placeholder="Horario 1" value="{{$horario1}}">
			<input type="text" name="horario2" placeholder="Horario 2" value="{{$horario2}}">
			<input type="text" name="horario3" placeholder="Horario 3" value="{{$horario3}}">
			<input type="text" name="horario4" placeholder="Horario 4" value="{{$horario4}}">
			<input type="text" name="horario5" placeholder="Horario 5" value="{{$horario5}}">
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
		$('select').material_select();

		$('#status').change(function() {
			var $input = $( this );
			if( $input.prop('checked') == true )
				$('label[for="status"]').html('Publicada');
			else
				$('label[for="status"]').html('Borrador');
		}).change();
	});
</script>
@stop