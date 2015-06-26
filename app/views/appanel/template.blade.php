<!doctype html>
<html>
<head>
	<link rel="stylesheet/less" href="{{URL::asset('/panel/less/dashboard.less')}}" />
	<link rel="stylesheet" href="{{URL::asset('/panel/css/icons.css')}}">
	<link rel="stylesheet" href="{{URL::asset('/panel/css/sweet.css')}}">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

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

	<style>
		body {
		}
		.sub-header {
		    padding-bottom: 10px;
		    border-bottom: 1px solid #eee;
		}
		.navbar-fixed-top {
		    border: 0;
		}
		.sidebar {
		    display: none;
		}
		@media (min-width: 768px) {
		    .sidebar {
		        position: fixed;
		        top: 0;
		        bottom: 0;
		        left: 0;
		        z-index: 1000;
		        display: block;
		        padding: 20px;
		        overflow-x: hidden;
		        overflow-y: auto;
		        background-color: #f5f5f5;
		        border-right: 1px solid #eee;
		    }
		}
		.nav-sidebar {
		    margin-right: -21px;
		    margin-bottom: 20px;
		    margin-left: -20px;
		}
		.nav-sidebar > li > a {
		    padding-right: 20px;
		    padding-left: 20px;
		}
		.nav-sidebar > .active > a,
		.nav-sidebar > .active > a:hover,
		.nav-sidebar > .active > a:focus {
		    color: #fff;
		    background-color: #428bca;
		}
		.main {
		    padding: 20px;
		}
		@media (min-width: 768px) {
		    .main {
		        padding-right: 40px;
		        padding-left: 40px;
		    }
		}
		.main .page-header {
		    margin-top: 0;
		}
		.placeholders {
		    margin-bottom: 30px;
		    text-align: center;
		}
		.placeholders h4 {
		    margin-bottom: 0;
		}
		.placeholder {
		    margin-bottom: 20px;
		}
		.placeholder img {
		    display: inline-block;
		    border-radius: 50%;
		}
	</style>
	@section('styles')

	@show


	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>

	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/less.js/2.5.0/less.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/mustache.js/0.8.1/mustache.min.js"></script>

	<script src="{{URL::asset('/panel/js/persist.js')}}"></script>
	<script src="{{URL::asset('/panel/js/sweet.js')}}"></script>
	@section('scripts')

	@show
	<script src="{{URL::asset('/panel/js/index.js')}}"></script>

	<title>{{$title}} | Dashboard</title>
</head>
<body>

<div class="container-fluid">
<div class="row">

	@section('sidebar')
        <div class="col-sm-3 col-md-2 sidebar">

			<ul class="nav nav-sidebar user">
				@if(Auth::check())
				<li class="avatar">
					<figure>
						<img src="{{URL::asset('/pictures/sqm/' . Auth::user()->picture->url)}}" />
					</figure>
					<div class="contain">
						<h1>{{Auth::user()->name}}</h1>
						<h2><span>@</span>{{Auth::user()->username}}</h2>
						<span><a href="{{route('appanel')}}/user/{{Auth::user()->uid}}/edit">Editar</a></span>
					</div>
				</li>
			</ul>

			<ul class="nav nav-sidebar">
				@endif

				<li{{$section=='index'?' class="active"':''}}>
					<a href="{{route('appanel')}}">
						<i class="icon-home"></i>
						<span>Inicio</span>
					</a>
				</li>

				<li{{$section=='channels'?' class="active"':''}}>
					<a href="{{route('appanel.channels.index')}}">
						<i class="icon-tv"></i>
						<span>Canales</span>
					</a>
				</li>

				<li{{$section=='events'?' class="active"':''}}>
					<a href="{{route('appanel.events.index')}}">
						<i class="icon-event"></i>
						<span>Eventos</span>
					</a>
				</li>

			</ul>
			<ul class="nav nav-sidebar">

				<li{{$section=='users'?' class="active"':''}}>
					<a href="{{route('appanel.user.index')}}">
						<i class="icon-people"></i>
						<span>Usuarios</span>
					</a>
				</li>

			</ul>
			<ul class="nav nav-sidebar">

				<li>
					<a href="{{route('logout')}}">
						<i class="icon-exit-to-app"></i>
						<span>Salir</span>
					</a>
				</li>

			</ul>
	</div>
	@show

	<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		<h1 class="page-header">{{$title}}</h1>
		<!-- <h2>{{$subtitle}}</h2> -->

		@section('content')
		@show

	</div>

</div></div>
</body>
</html>





