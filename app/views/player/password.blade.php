<!doctype html>
<html lang="es-Mx">
<head>
	<meta charset="utf-8">
	<title>{{$title}} | AMB Multimedia</title>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script>
	document.oncontextmenu = function(){ return false; };
	document.onselectstart = function(){ return false; };
	</script>

    <link href='http://fonts.googleapis.com/css?family=Roboto+Slab:400,300,100,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link href="//fonts.googleapis.com/css?family=Lato:300,400&amp;subset=latin,latin-ext" rel="stylesheet" type="text/css">
	<style>
	* {
		margin: 0;
		padding: 0;
		cursor: arrow;
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
		padding: 4em 2em;
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
	form {
		display: block;
		text-align: center;
		margin: .8em;
	}
	input {
		display: block;
		width: 10em;
		color: #000;
		border-radius: 4px;
		border: 0;
		padding: .3em .5em;
		font-size: 1em;
		font-family: 'Roboto Slab', serif;
		font-weight: 100;
		background: rgba(255,255,255,.3);
		margin: auto;
		transition: all .3s;
	}
		input:focus {
			background: #fff;
		}
	button {
		margin-top: 1em;
		background: #fff;
		border: 0;
		display: inline-block;
		color: #222;
		padding: .6em 1em;
		text-transform: uppercase;
		text-decoration: none;
		font-size: .6em;
		font-family: 'Roboto Slab', serif;
		border-radius: 4px;
		transition: all .3s;
		cursor: pointer;
	}
		button:hover {
			background: #eee;
			box-shadow: 0px 2px 15px 7px rgba(0,0,0,.2);
		}
		button:active {
			box-shadow: 0px 0px 0px 0px rgba(0,0,0,0);
		}

	@media (max-width: 560px) {
		h1 {
			font-size: 1.8em;
		}
		h2 {
			font-size: .8em;
		}
	}
	</style>
</head>
<body>
  <div id="cover">
  </div>
  <div id="info">
  	<h1>{{$title}}</h1>
  	<h2>Ingresa la contraseña para poder ver el evento</h2>
  	@if($errors->any())
		<div>
			<p style="color:red">{{$errors->first()}}</p>
		</div>
	@endif
  	{{Form::model($event, array('route' => array('player.event.unlock', $event->uid), 'method' => 'PUT'))}}
  		<input type="password" name="password" placeholder="Contraseña" />
  		<button>Entrar</button>
  	{{Form::close()}}
  </div>
</body>
</html>