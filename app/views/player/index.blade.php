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

			var muted = false;
			var loc = window.location.href;
			if (loc.match(/\muted/gi)) {
				muted = true;
			}

			@if(!Agent::isMobile() && !Agent::isTablet())
			var myPlayer = videojs('liveplayer');
			if (muted) {
				myPlayer.muted(true);
			}


			myPlayer.ready(function($) {
				if ( !myPlayer.muted() && muted) {
					myPlayer.muted(true);
				}
			});
			@endif
		}
		$(r);
		document.oncontextmenu = function(){ return false; };
		document.onselectstart = function(){ return false; };
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

		@if(!Agent::isMobile() && !Agent::isTablet())
			@if($status != 'live')
				.vjs-time-divider, .vjs-duration, .vjs-current-time-display {
					display: block;
				}
				.vjs-current-time.vjs-time-controls.vjs-control {
				  width: 4em;
				  text-align: center;
				}
				.vjs-default-skin .vjs-progress-control {
					position: absolute;
					left: 145px;
					right: 135px;
					width: auto;
					font-size: 0.5em;
					height: 1em;
					top: 2.3em;
					-webkit-transition: all 0.4s;
					-moz-transition: all 0.4s;
					-o-transition: all 0.4s;
					transition: all 0.4s;
					display: block;
					opacity: .5;
				}

				.vjs-default-skin:hover .vjs-progress-control {
					-webkit-transition: all 0.2s;
					-moz-transition: all 0.2s;
					-o-transition: all 0.2s;
					transition: all 0.2s;
					opacity: 1;
				}
				.vjs-default-skin .vjs-progress-holder {
					height: 100%;
				}
				.vjs-default-skin .vjs-progress-holder .vjs-play-progress,
				.vjs-default-skin .vjs-progress-holder .vjs-load-progress,
				.vjs-default-skin .vjs-progress-holder .vjs-load-progress div {
					position: absolute;
					display: block;
					height: 100%;
					margin: 0;
					padding: 0;
					width: 0;
					left: 0;
					top: 0;
				}
				.vjs-default-skin .vjs-play-progress {
					background: #66a8cc;
				}
				.vjs-default-skin .vjs-load-progress {
					background: rgba(255, 255, 255, 0.2);
				}
				.vjs-default-skin .vjs-load-progress div {
					background: rgba(255, 255, 255, 0.1);
				}
				.vjs-default-skin .vjs-seek-handle {
					width: 1.5em;
					height: 100%;
				}
				.vjs-default-skin .vjs-seek-handle:before {
					padding-top: 0.1em;
				}
				.vjs-default-skin .vjs-slider-handle:before {
					content: '';
					display: none;
				}
				.vjs-progress-holder.vjs-slider {
					background-color: rgba(51, 51, 51, 0.7);
				}
			@endif
		@endif
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















