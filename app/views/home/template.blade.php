<!DOCTYPE html>
<html lang="es">
	<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#">
		<title>{{$title}} | AMB Multimedia</title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		@section('metas')
		@show

		<link href='http://fonts.googleapis.com/css?family=Roboto+Slab:400,300,100,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
		<link rel="stylesheet/less" href="{{URL::asset('/assets/home/less/default.less')}}">
		@section('styles')
		@show

		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/less.js/2.5.0/less.min.js"></script>
		@section('scripts')
		@show
	</head>
	<body>
		<div id="fb-root"></div>
		<script>
		(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&appId=357058997800769&version=v2.0";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
		</script>

		<nav>
			<div class="center">
				<h1>AMB Streaming</h1>
				<ul>
					<li><a href="{{route('home.index')}}">Inicio</a></li>
					<li><a href="{{route('home.index')}}">Canales</a></li>
					<li><a href="{{route('home.events')}}">Eventos</a></li>
				</ul>
			</div>
		</nav>

		@section('content')
		@show

		<footer id="amb">
			<div class="center">
				<h1><span>Power By</span></h1>
				<a href="//ambmultimedia.com.mx" target="_blank">AMB Multimedia</a>
			</div>
		</footer>

	</body>
</html>