<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Identificate | AMB Streaming</title>
</head>
<body>
<style type="text/css">
	input{
		display: block;
		margin-bottom: 2em;
		bottom: 10px;
	}
</style>

	<h2>Bienvenido</h2>

	 {{ Form::open(array('url' => 'cervantino/login', 'method' => 'POST')) }}
        <input type="text" name="email" /> <br />
        <input type="password" name="password" /> <br />
        <input type="submit" value="Ingresar" />
    {{ Form::close() }}

</body>
</html>