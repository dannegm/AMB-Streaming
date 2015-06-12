<!DOCTYPE html>
<html lang="es">
	<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#">
		<title>{{$event->title}} | AMB Multimedia</title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- Open Graph Support-->
		<meta property="og:title" content="La fiesta de las jaranas y las tarimas">
		<meta property="og:description" content="">

		<link href="//fonts.googleapis.com/css?family=Lato:300,400&amp;subset=latin,latin-ext" rel="stylesheet">
		<link rel="stylesheet" href="{{URL::asset('/assets/landing/css/index.css')}}">

		<style>
			header {
				background-image: url('{{URL::asset("/pictures/large/" . $event->background->url)}}');
			}
		</style>
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

		<header>
			<div class="center">
				@if( $event->logo_uid != "avatarTV" )
				<h1 style="text-align: center;">
					<img src="{{URL::asset("/pictures/normal/" . $event->logo->url)}}" style="max-width: 720px; width: auto;" />
				</h1>
				@else
				<h1>{{$event->title}}</h1>
				<h2>{{$event->subtitle}}</h2>
				@endif
				<div id="containvideo">
					<amb:video></amb:video>
					<script>
						(function() {
							var tv = document.getElementsByTagName('amb:video')[0];
							var width = tv.getAttribute('width');
							var iframe = document.createElement('iframe');

							iframe.src = '{{URL::asset("event/{$event->uid}/player")}}';
							iframe.style.position = 'absolute';
							iframe.setAttribute('frameborder', '0');
							iframe.setAttribute('allowfullscreen', 'true');
							iframe.setAttribute('style', 'width: 100%; height: 100%; display: block;');

							var divContent = document.createElement('div');
							divContent.setAttribute('style', 'width: ' + width + 'px;');

							tv.appendChild(divContent);
							divContent.appendChild(iframe);

							function resize () {
								divContent.style.height = parseInt(divContent.offsetWidth * 0.5625) + 'px';
							}

							window.onresize = resize;
							resize();
						})();
					</script>
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
		<footer id="amb">
			<div class="center">
				<h1><span>Power By</span></h1>
				<a href="//ambmultimedia.com.mx" target="_blank">AMB Multimedia</a>
			</div>
		</footer>
	</body>
</html>