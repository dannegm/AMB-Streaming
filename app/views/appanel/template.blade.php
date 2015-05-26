<!doctype html>
<html>
<head>
	<link rel="stylesheet/less" href="{{URL::asset('/panel/less/dashboard.less')}}" />
	<link rel="stylesheet" href="{{URL::asset('/panel/css/icons.css')}}">
	<link rel="stylesheet" href="{{URL::asset('/panel/css/sweet.css')}}">
	@section('styles')

	@show

	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
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
	@section('sidebar')
	<section id="sidebar">
		<ul>
			@if(Auth::check())
			<li class="avatar">
				<figure>
					<img src="{{URL::asset('/pictures/sqm/' . Auth::user()->picture->url)}}" />
				</figure>
				<div class="container">
					<h1>{{Auth::user()->name}}</h1>
					<h2><span>@</span>{{Auth::user()->username}}</h2>
				</div>
			</li>
			@endif

			<li{{$section=='index'?' class="active"':''}}>
				<a href="{{route('appanel')}}" class="waves-effect waves-teal">
					<i class="icon-home"></i>
					<span>Inicio</span>
				</a>
			</li>

			<li{{$section=='channels'?' class="active"':''}}>
				<a href="{{route('appanel.channels.index')}}" class="waves-effect waves-teal">
					<i class="icon-tv"></i>
					<span>Canales</span>
				</a>
			</li>

			<li{{$section=='events'?' class="active"':''}}>
				<a href="{{route('appanel.events.index')}}" class="waves-effect waves-teal">
					<i class="icon-event"></i>
					<span>Eventos</span>
				</a>
			</li>

			<li class="separator"></li>

			<li{{$section=='users'?' class="active"':''}}>
				<a href="{{route('appanel.user.index')}}" class="waves-effect waves-teal">
					<i class="icon-people"></i>
					<span>Usuarios</span>
				</a>
			</li>

			<li class="separator"></li>

			<li>
				<a href="{{route('logout')}}" class="waves-effect waves-teal">
					<i class="icon-exit-to-app"></i>
					<span>Salir</span>
				</a>
			</li>

		</ul>
	</section>
	@show

	<main>
		<header id="globalheader">
			<h1>{{$title}}</h1>
			<h2>{{$subtitle}}</h2>
		</header>
	@section('content')
	@show
	<main>

</main>
</body>
</html>





