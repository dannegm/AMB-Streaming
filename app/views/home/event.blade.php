@extends('home/template')

@section('metas')
	<meta property="og:title" content="{{$event->title}}">
	<meta property="og:description" content="{{strip_tags(addslashes($event->subtitle))}}">
	<meta property="og:url" content="{{route('home.event', array('uid' => $event->uid, 'void' => urlencode($event->title)))}}" />
	<meta property="og:type" content="video.other" />
	<meta property="og:site_name" content="AMB Streaming" />

	<meta property="og:image" content="{{URL::asset('/pictures/medium/' . $event->cover->url)}}" />
	<meta property="og:image:type" content="{{$event->cover->content_type}}" />
	<meta property="og:image:width" content="{{$event->cover->width}}" />
	<meta property="og:image:height" content="{{$event->cover->height}}" />

	<meta property="og:video" content="{{route('player.event', array('uid' => $event->uid))}}" />
	<meta property="og:video:type" content="text/html" />
	<meta property="og:video:width" content="720" />
	<meta property="og:video:height" content="405" />
@stop

@section('styles')
<link href="//fonts.googleapis.com/css?family=Lato:300,400&amp;subset=latin,latin-ext" rel="stylesheet">
<link rel="stylesheet/less" href="{{URL::asset('/assets/home/less/event.less')}}">

@if ($event->theme != 'normal')
<link rel="stylesheet/less" href="{{URL::asset('/assets/home/themes/' . $event->theme . '.less')}}">
@endif

<style>
	header {
		background-image: url('{{URL::asset("/pictures/large/" . $event->background->url)}}');
	}
</style>
@stop

@section('scripts')
@stop

@section('content')

	@if($event->psswdreq)

	<?php
		$login = Cookie::get('L' . $event->uid);
		if ($login != $event->password):
	?>
	<style>
	#content {
		-webkit-filter: blur(15px);
		-moz-filter: blur(15px);
		-o-filter: blur(15px);
		-ms-filter: blur(15px);
		filter: blur(15px);
	}
	#overlie {
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		z-index: 99;
		background-color: rgba(0,0,0,.8);
	}
	#overlie article {
		margin: 8em auto;
		max-width: 720px;
		width: auto;
		color: #fff;
		text-align: center;
	}
	#overlie article h2 {
		font-weight: 300;
		font-size: 2em;
		margin: 1em;
		text-align: center;
	}
	#overlie article form {
		display: block;
		text-align: center;
		margin: .8em;
	}
	#overlie article input {
		display: block;
		width: 15em;
		color: #000;
		border-radius: 4px;
		border: 0;
		padding: .5em .8em;
		font-size: 1em;
		font-family: 'Roboto Slab', serif;
		font-weight: 100;
		background: rgba(255,255,255,.3);
		margin: auto;
		transition: all .3s;
	}
		#overlie article input:focus {
			background: #fff;
		}
	#overlie article button {
		margin-top: 1.5em;
		background: #fff;
		border: 0;
		display: inline-block;
		color: #222;
		padding: .8em 1.4em;
		text-transform: uppercase;
		text-decoration: none;
		font-size: .8em;
		font-family: 'Roboto Slab', serif;
		border-radius: 4px;
		transition: all .3s;
		cursor: pointer;
	}
		#overlie article button:hover {
			background: #eee;
			box-shadow: 0px 2px 15px 7px rgba(0,0,0,.2);
		}
		#overlie article button:active {
			box-shadow: 0px 0px 0px 0px rgba(0,0,0,0);
		}
	</style>
	<div id="overlie">

		<article>
			<h2>Ingresa la contraseña para poder ver el evento</h2>
			@if($errors->any())
				<div>
					<p style="color:red;text-align:center;">{{$errors->first()}}</p>
				</div>
			@endif
			{{Form::model($event, array('route' => array('home.event.unlock', $event->uid), 'method' => 'PUT'))}}
				<input type="password" name="password" placeholder="Contraseña" />
				<button>Entrar</button>
			{{Form::close()}}
		</article>
		
	</div>
	<?php endif; ?>
	@endif


	<div id="content">
		<header>
			<div class="center">
				@if( $event->logo_uid != "avatarTV" )
				<h1 style="text-align: center;">
					<img src="{{URL::asset("/pictures/normal/" . $event->logo->url)}}" />
				</h1>
				@else
				<h1>{{$event->title}}</h1>
				<h2>{{$event->locale}}</h2>
				@endif

				<div id="containvideo">
					<script>
					(function() {
					var sc=document.createElement("script");sc.type="text/javascript";sc.async=true;
					sc.src="//video.ambmultimedia.mx/api/widget.js";
					var s=document.getElementsByTagName("script")[0];s.parentNode.insertBefore(sc,s)
					})();
					</script>
					<amb:video uid="{{$event->uid}}" type="event"></amb:video>
				</div>
			</div>
		</header>

		<footer class="video">
			<div class="center">
				<div class="contain">
				</div>
			</div>
		</footer>

		<div class="social">
			@if($event->socialinfo != 0)
			<div class="center">
				<!-- facebook -->
				<div class="fb-like" data-href="{{URL::asset('event/' . $event->uid  . '/')}}" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>
			</div>
			@endif
		</div>

		<article>
			<div class="center">
			{{$event->description}}
			</div>
			<div class="sep"></div>
		</article>
		<div class="center">
			@if($event->comments != 0)
			<div id="disqus_thread"></div>
			<script type="text/javascript">
				var disqus_shortname = 'ambmultimedia';
				(function() {
					var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
					dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
					(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
				})();
			</script>
			<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
			@endif
		</div>
	</div>
@stop