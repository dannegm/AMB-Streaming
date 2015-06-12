<!doctype html>
<html lang="es-Mx">
<head>
	<meta charset="utf-8">
	<title>{{$title}} | AMB Multimedia</title>

	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	@if(!Agent::isMobile() && !Agent::isTablet())
	<link rel="stylesheet" href="{{URL::asset('/assets/player/video-js/video-js.css')}}" />
	<script src="{{URL::asset('/assets/player/video-js/video.js')}}"></script>
	<script src="{{URL::asset('/assets/player/js/jquery.tinytimer.min.js')}}"></script>
	@endif

	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		ga('create', 'UA-47107007-1', 'auto');
		ga('send', 'pageview');

		var _ = (function (e) { return document.getElementById(e); });
		function resize () {
			$('#liveplayer').attr('width', $(window).width());
			$('#liveplayer').attr('height', $(window).height());
			$('#liveplayer').css({
				'width': $(window).width() + 'px',
				'height': $(window).height() + 'px'
			});
		}
		function r () {
			resize();
			$(window).resize(resize);
			_('liveplayer').play();


			@if(!Agent::isMobile() && !Agent::isTablet())
				@if($status == 'live')

					var start = new Date('{{$start}}');
					$('#timer').tinyTimer({
						from: start,
						format: '<strong>EN VIVO</strong>&nbsp;&nbsp;&nbsp;%0H:%0m:%0s',
					    onTick: function () {
					        $('#timer').css({
					        	'opacity': $('.vjs-control-bar').css('opacity')
					        })
					    }
					});

				@else

					$('.vjs-current-time-display').show();

				@endif
			@endif
		}
		$(r);
	</script>

	<style>
		body, html {
			margin: 0;
			overflow: hidden;
			background: #000;
		}
		#timer {
			position: absolute;
			opacity: 0;
			color: #fff;
			z-index: 9999;
			bottom: 0px;
			left: 60px;

			font-style: normal;
			font-family: Arial, sans-serif;
			-webkit-user-select: none;
			font-size: 10px;
			line-height: 3em;

			-webkit-transition: opacity 1s;
			-moz-transition: opacity 1s;
			-o-transition: opacity 1s;
			transition: opacity 1s;
		}
			#timer:before {
				content: ' ';
				display: block;
				width: 6px;
				height: 6px;
				background: red;
				border-radius: 50%;
				position: absolute;
				margin-top: 12px;
				margin-left: -12px;
			}
		#liveplayer {
			width: 100%;
			height: 100%;
			margin: 0;
			padding: 0;
			background: #000;
			position: absolute;
		}
	</style>

</head>
<body>

	@if(Agent::isMobile() || Agent::isTablet())
		<video id="liveplayer" controls{{$autoplay}}
			src="{{str_replace('rtmp', 'http', $rtmp)}}/playlist.m3u8"
			poster="{{URL::asset('/pictures/normal/' . $cover)}}"></video>
	@else
		<span id="timer"></span>
		<video id="liveplayer" class="video-js vjs-default-skin" controls{{$autoplay}} preload="auto"
			data-setup='{ "techOrder": ["flash"] }'
			poster="{{URL::asset('/pictures/normal/' . $cover)}}">
			<source src="{{$rtmp}}" type='rtmp/mp4'>
		</video>
	@endif
</body>
</html>















