@extends('home/template')

@section('metas')
	<meta property="og:title" content="{{$event->title}}">
	<meta property="og:description" content="{{$event->subtitle}}">
@stop

@section('styles')
<link href="//fonts.googleapis.com/css?family=Lato:300,400&amp;subset=latin,latin-ext" rel="stylesheet">
<link rel="stylesheet/less" href="{{URL::asset('/assets/home/less/event.less')}}">
<style>
	header {
		background-image: url('{{URL::asset("/pictures/large/" . $event->background->url)}}');
	}
</style>
@stop

@section('scripts')
@stop

@section('content')
		<header>
			<div class="center">
				@if( $event->logo_uid != "avatarTV" )
				<h1 style="text-align: center;">
					<img src="{{URL::asset("/pictures/normal/" . $event->logo->url)}}" style="max-width: 720px; width: auto;" />
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
			<div class="center">
				<!-- facebook -->
				<div class="fb-like" data-href="{{URL::asset('event/' . $event->uid  . '/')}}" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>
			</div>
		</div>

		<article>
			<div class="center">
			{{$event->description}}
			</div>
			<div class="sep"></div>
		</article>
		<div class="center">
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
		</div>

@stop