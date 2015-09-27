<!DOCTYPE html>
<html lang="es">
	<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# video: http://ogp.me/ns/video#">
		<title>{{$title}} | Streaming</title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		@section('metas')
		@show

		<link rel="apple-touch-icon" sizes="57x57" href="{{URL::asset('/favicons/apple-touch-icon-57x57.png')}}">
		<link rel="apple-touch-icon" sizes="60x60" href="{{URL::asset('/favicons/apple-touch-icon-60x60.png')}}">
		<link rel="apple-touch-icon" sizes="72x72" href="{{URL::asset('/favicons/apple-touch-icon-72x72.png')}}">
		<link rel="apple-touch-icon" sizes="76x76" href="{{URL::asset('/favicons/apple-touch-icon-76x76.png')}}">
		<link rel="apple-touch-icon" sizes="114x114" href="{{URL::asset('/favicons/apple-touch-icon-114x114.png')}}">
		<link rel="apple-touch-icon" sizes="120x120" href="{{URL::asset('/favicons/apple-touch-icon-120x120.png')}}">
		<link rel="apple-touch-icon" sizes="144x144" href="{{URL::asset('/favicons/apple-touch-icon-144x144.png')}}">
		<link rel="apple-touch-icon" sizes="152x152" href="{{URL::asset('/favicons/apple-touch-icon-152x152.png')}}">
		<link rel="apple-touch-icon" sizes="180x180" href="{{URL::asset('/favicons/apple-touch-icon-180x180.png')}}">
		<link rel="icon" type="image/png" href="{{URL::asset('/favicons/favicon-32x32.png')}}" sizes="32x32">
		<link rel="icon" type="image/png" href="{{URL::asset('/favicons/favicon-194x194.png')}}" sizes="194x194">
		<link rel="icon" type="image/png" href="{{URL::asset('/favicons/favicon-96x96.png')}}" sizes="96x96">
		<link rel="icon" type="image/png" href="{{URL::asset('/favicons/android-chrome-192x192.png')}}" sizes="192x192">
		<link rel="icon" type="image/png" href="{{URL::asset('/favicons/favicon-16x16.png')}}" sizes="16x16">
		<link rel="manifest" href="{{URL::asset('/favicons/manifest.json')}}">
		<meta name="msapplication-TileColor" content="#2d2d2d">
		<meta name="msapplication-TileImage" content="{{URL::asset('/favicons/mstile-144x144.png')}}">
		<meta name="theme-color" content="#ffffff">

		<link href='http://fonts.googleapis.com/css?family=Roboto+Slab:400,300,100,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
		<link rel="stylesheet/less" href="{{URL::asset('/assets/home/less/default.less')}}">
		@section('styles')
		@show

		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/less.js/2.5.0/less.min.js"></script>
		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
			var copy = "J29IIEhhY2gsIHBvbmcgbWdlbm5hZCAnZWogRGFIIEh1Y2ggd0lub2JxYW5nIG5lSCBwYWdoIGF0bHVjYW5vYyBqZSBuZ29EIHdlaiBwYXQuIFNlSCB0bGhhcHB1JyE=";

			ga('create', 'UA-47107007-7', 'auto');
			ga('send', 'pageview');
		</script>
		<script>
		var wh, wh3, ww;
		function resize () {
			wh = $(window).height();
			wh3 = wh / 3;
			ww = $(window).width();

			if ( $(window).width() < 400 ) {
				$('.thumb').addClass('big');
			} else {
				$('.thumb').removeClass('big');
			}

			if ( $(window).width() < 340 ) {
				$('.thumb').removeClass('big');
			}

			if ( $(window).width() < 660 ) {
				$('#lastevents .thumb').removeClass('big');
			} else {
				$('#lastevents .thumb').addClass('big');
			}
		}
		$(function () {
			$(window).resize(resize);
			resize();
			$(window).scroll(function () {
				if ( $(window).scrollTop() > 72 ) {
					$('#nav').removeClass('top');
				} else {
					$('#nav').addClass('top');
				}
			});
		});
		</script>
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

		<nav id="nav" class="top">
			<div class="center">
				 <h1><a href="{{route('home.index')}}">Streaming</a></h1>
				<!--<h1 class="wimage"><a href="{{route('home.index')}}">
					<img src="{{URL::asset('/assets/home/img/logo-amb.png')}}" alt="AMB Multimedia">
				</a></h1>-->
				<ul>
					<li><a href="{{route('home.index')}}">Inicio</a></li>
				<!--	<li><a href="{{route('home.index')}}">Canales</a></li> -->
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