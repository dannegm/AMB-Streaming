@extends('appanel/template')
@section('content')
<main>
	<!-- Header -->
	<nav id="top" class="top-nav">
		<span class="page-title">{{$title}}</span>
	</nav>

	<!-- Listado -->
	<div class="row">
	@foreach ($talleres as $taller)
		<div class="col s4 drag" data-item="{{$taller->id}}" id="item-{{$taller->id}}">
			<div class="card small">
				<div class="card-image waves-effect waves-block waves-light">
					<img class="activator" src="{{$taller->imgsrc}}">
					<span class="card-title">{{$taller->title}}</span>
				</div>
				<div class="card-content">
					<span class="card-title activator grey-text text-darken-4">{{$taller->artista}} <i class="mdi-navigation-more-vert right"></i></span>
					<p>{{$taller->presentacion}}</p>
				</div>
				<div class="card-reveal">
					<span class="card-title grey-text text-darken-4">Opciones <i class="mdi-navigation-close right"></i></span>
					<ul class="collection">
						<li class="collection-item"><a href="taller/{{$taller->id}}/edit"><i class="mdi-content-create"></i> Editar</a></li>
						<li class="collection-item"><a class="delete" href="taller/{{$taller->id}}/destroy"><i class="mdi-action-delete"></i> Borrar</a></li>
					</ul>
				</div>
			</div>
		</div>
	@endforeach
	</div>

	<!-- Floating button -->
	<div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
		<a href="taller/create" class="btn-floating btn-large red">
			<i class="large mdi-content-create"></i>
		</a>
	</div>

	<!-- Footer -->
	<footer id="footer" class="page-footer blue-grey darken-2">
		<div class="row">
			<div class="col l6 s12">
				{{$talleres->links()}}
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
@stop
