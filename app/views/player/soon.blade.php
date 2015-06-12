<!doctype html>
<html lang="es-Mx">
<head>
	<meta charset="utf-8">
	<title>{{$title}} | AMB Multimedia</title>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="{{URL::asset('/assets/player/js/jquery.countdown.min.js')}}"></script>
	<script>
	$(function () {
		$('#clock').countdown('{{$date}}')
			.on('update.countdown', function(event) {
				var format = '%-S segundo%!S';
				if (event.offset.minutes > 0) {
					format = '%-M minuto%!M %-S segundo%!S';
				}
				if (event.offset.hours > 0) {
					format = '%-H  hora%!H %-M minuto%!M';
				}
				if (event.offset.days > 0) {
					format = '%-d día%!d %-H  hora%!H';
				}
				if (event.offset.weeks > 0) {
					format = '%-w semana%!w y %-d día%!d';
				}
				if (event.offset.months > 0) {
					format = '%-m %!m:mes,meses; y %-d día%!d';
				}
				$(this).html(event.strftime(format));
			})
			.on('finish.countdown', function(event) {
				window.location.reload();
			});
	});
	</script>

    <link href='http://fonts.googleapis.com/css?family=Roboto+Slab:400,300,100,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link href="//fonts.googleapis.com/css?family=Lato:300,400&amp;subset=latin,latin-ext" rel="stylesheet" type="text/css">
	<style>
	* {
	  margin: 0;
	  padding: 0;
	}
	html, body {
	  background: #222;
	  font-family: 'Roboto Slab', serif;
	  color: #fff;
	  font-size: 16px;
	}

	#cover {
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background: url("{{URL::asset('/pictures/normal/' . $cover)}}");
		background-size: cover;
		z-index: 1;
	}
	#info {
		position: absolute;
		bottom: 0;
		left: 0;
		right: 0;
		padding: 5em 2em;
		padding-top: 10em;
		text-align: center;
		z-index: 5;

		background: -moz-linear-gradient(top,  rgba(0,0,0,0) 0%, rgba(0,0,0,0.85) 100%);
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(0,0,0,0)), color-stop(100%,rgba(0,0,0,0.85)));
		background: -webkit-linear-gradient(top,  rgba(0,0,0,0) 0%,rgba(0,0,0,0.85) 100%);
		background: -o-linear-gradient(top,  rgba(0,0,0,0) 0%,rgba(0,0,0,0.85) 100%);
		background: -ms-linear-gradient(top,  rgba(0,0,0,0) 0%,rgba(0,0,0,0.85) 100%);
		background: linear-gradient(to bottom,  rgba(0,0,0,0) 0%,rgba(0,0,0,0.85) 100%);
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#00000000', endColorstr='#a6000000',GradientType=0 );
	}
	h1, h2 {
		font-weight: 300;
	}
	h1 {
		font-size: 3em;
	}
	h2 {
		font-size: 1em;
	}
	</style>
</head>
<body>
  <div id="cover">
  </div>
  <div id="info">
  	<h1>{{$title}}</h1>
  	<h2>En vivo en <span id="clock"></span></h2>
  </div>
</body>
</html>