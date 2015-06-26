<!doctype html>
<html lang="es-Mx">
<head>
	<meta charset="utf-8">
	<title>{{$title}} | AMB Multimedia</title>
    <link href='http://fonts.googleapis.com/css?family=Roboto+Slab:400,300,100,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	<style>
	* {
		margin: 0;
		padding: 0;
		cursor: arrow;
	}
	html, body {
		font-family: 'Roboto Slab', serif;
		background: #eee;
		color: #888;
	}
	h1, h2 {
		font-weight: 300;
		text-align: center;
	}
	h2 {
		font-weight: 100;
	}
	#text {
		display: block;
		overflow: hidden;
		height: 70px;
		position:absolute;
		width: 100%;
		top: 50%;
		margin-top: -35px;
	}

	@if(!empty($cover))
	#background {
		position: absolute;
		bottom: 0;
		left: 0;
		right: 0;
		top: 0;
		background: #222 url("{{URL::asset('/pictures/normal/' . $cover)}}");
		background-size: cover;
	}
	#text {
		color: #fff;
	}
	#overlive {
		position: absolute;
		bottom: 0;
		left: 0;
		right: 0;
		top: 0;

		background: -moz-linear-gradient(top,  rgba(0,0,0,0) 0%, rgba(0,0,0,0.65) 100%);
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(0,0,0,0)), color-stop(100%,rgba(0,0,0,0.65)));
		background: -webkit-linear-gradient(top,  rgba(0,0,0,0) 0%,rgba(0,0,0,0.65) 100%);
		background: -o-linear-gradient(top,  rgba(0,0,0,0) 0%,rgba(0,0,0,0.65) 100%);
		background: -ms-linear-gradient(top,  rgba(0,0,0,0) 0%,rgba(0,0,0,0.65) 100%);
		background: linear-gradient(to bottom,  rgba(0,0,0,0) 0%,rgba(0,0,0,0.65) 100%);
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#00000000', endColorstr='#a6000000',GradientType=0 );
	}
	@endif

	@media (max-width: 560px) {
		h1 {
			font-size: 1.8em;
		}
		h2 {
			font-size: .8em;
		}
	}
	</style>
	<script>
	document.oncontextmenu = function(){ return false; };
	document.onselectstart = function(){ return false; };
	</script>
</head>
<body>
  <div id="background"></div>
  <div id="overlive"></div>
  <div id="text">
  <h1>Lo sentimos :(</h1>
  <h2>{{$error}}</h2>
  </div>
</body>
</html>