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
		{{Form::open(array('url' => route('appanel.events.store')))}}
			<div class="row">
				<div class="input-field col s12 big">
					<label>Nombre</label>
					<input type="text" name="name" value="{{Input::old('name')}}">
				</div>
			</div>
			<div class="row">
				<div class="input-field col s12">
					<label>Descripción</label>
					<textarea class="materialize-textarea" name="description" >{{Input::old('description')}}</textarea>
				</div>
			</div>
			<div class="row">
				<div class="input-field col s6">
					<label>Canal asociado</label>
					<br />
					<select name="channel" class="browser-default">
      					<option value="" disabled selected>Selecciona un canal</option>

					@foreach($channels as $c)
						<option value="{{$c->uid}}">{{$c->name}}</option>
					@endforeach

					</select>
				</div>
			</div>
			<div class="row">
				<div class="input-fiel col s6">
					<label>Inicia</label>
					<input type="date" name="started_at" class="datepicker">
				</div>
				<div class="input-fiel col s6">
					<label>Termina</label>
					<input type="date" name="ended_at" class="datepicker">
				</div>
				<script>
				 $('.datepicker').pickadate({
					selectMonths: true, // Creates a dropdown to control month
					selectYears: 15 // Creates a dropdown of 15 years to control year
				});
				 </script>
			</div>
			<div class="row">
				<div class="input-fiel col s12">
					<button class="btn waves-effect waves-light right">Añadir</button>
				</div>
			</div>
		{{Form::close()}}
	</div>
@stop