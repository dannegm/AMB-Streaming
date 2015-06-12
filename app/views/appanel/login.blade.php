<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Panel de control - AMB Streaming</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
	<style>
		body {
			background-color: #eee;
		}
		form {
			width: 320px;
			height: 280px;
			padding: 15px;
			margin: 0 auto;

			position: absolute;
			top: 50%;
			left: 50%;
			margin-top: -160px;
			margin-left: -160px;
		}
		form .form-signin-heading,
		form .checkbox {
			margin-bottom: 10px;
		}
		form .checkbox {
			font-weight: normal;
		}
		form .form-control {
			position: relative;
			height: auto;
			-webkit-box-sizing: border-box;
			-moz-box-sizing: border-box;
			box-sizing: border-box;
			padding: 10px;
			font-size: 16px;
		}
		form .form-control:focus {
			z-index: 2;
		}
		form input[type="text"] {
			margin-bottom: -1px;
			border-bottom-right-radius: 0;
			border-bottom-left-radius: 0;
		}
		form input[type="password"] {
			margin-bottom: 10px;
			border-top-left-radius: 0;
			border-top-right-radius: 0;
		}
	</style>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</head>
<body>

	<div class="container">

		{{Form::open(array('url' => 'appanel/dologin', 'id'=>'login'))}}
			<h2 class="form-signin-heading">Iniciar sesión</h2>

			@if($errors->any())
				<div class="input-field col s12">
					<p style="color:red">{{$errors->first()}}</p>
				</div>
			@endif

			<label for="inputEmail" class="sr-only">Nombre de usuario</label>
			<input type="text" id="username" name="username" class="form-control" placeholder="Nombre de usuario" value="{{Input::old('username')}}" required autofocus>

			<label for="inputPassword" class="sr-only">Contraseña</label>
			<input type="password" id="inputPassword" name="password" class="form-control" placeholder="Contraseña" required>

			<button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>
		{{Form::close()}}

	</div>

</body>
</html>







