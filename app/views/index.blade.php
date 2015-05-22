<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Circovolador</title>
	<style>
		@import url(//fonts.googleapis.com/css?family=Lato:700);

		body {
			margin:0;
			font-family:'Lato', sans-serif;
			text-align:center;
			color: #999;
		}

		.welcome {
			width: 300px;
			height: 200px;
			position: absolute;
			left: 50%;
			top: 40%;
			margin-left: -150px;
			margin-top: -100px;
		}

		a, a:visited {
			text-decoration:none;
		}

		img{
			max-width: 100%;
			height: auto;
		}

		h1 {
			font-size: 32px;
			margin: 16px 0 0 0;
		}
	</style>
</head>
<body>
	<div class="welcome">
		<a href="http://ambmultimedia.com.mx" title="AMB Multimedia"><img src="{{URL::asset('amb.png')}}" alt="AMB Multimedia"></a>
		<h1>AMB Multimedia</h1>
	</div>
</body>
</html>
