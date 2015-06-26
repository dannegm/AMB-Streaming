@extends('home/template')

@section('metas')
@stop

@section('styles')
<link rel="stylesheet/less" href="{{URL::asset('/assets/home/less/e404.less')}}">
@stop

@section('scripts')
@stop

@section('content')

	<section id="header">
		<div class="overlive">
			<h1>404</h1>
		</div>
	</section>


	<!-- Eventos del canal -->

	<div class="center mtop row tcenter">
		<div class="row">
			<p>No hemos podido encontrar el contenido que estabas buscando</p>
			<p>Si te sientes un poco perdido trata de volver al inicio</p>
			<p><a href="{{route('home.index')}}" class="btn">Volver al inicio</a></p>
		</div>
	</div>

@stop




