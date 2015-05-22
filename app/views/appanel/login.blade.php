@extends('appanel/template')

@section('sidebar')
@stop

@section('content')

	<div class="container">
		<div class="row"></div>
		<div class="row"></div>
		<div class="row"></div>
		<div class="row">
			<div class="col s6 offset-s3">
				<div class="card-panel">
					<h1>Iniciar sesión</h1>
					{{Form::open(array('url' => 'appanel/dologin', 'id'=>'login'))}}
						@if($errors->any())
						<div class="input-field col s12">
							<p style="color:red">{{$errors->first()}}</p>
						</div>
						@endif
						<div class="input-field col s12">
							<input name="username" id="username" type="text" value="{{Input::old('username')}}">
							<label for="username">Nombre de usuario</label>
						</div>
						<div class="input-field col s12">
							<input name="password" id="password" type="password">
							<label for="password">Contraseña</label>
						</div>
						<div class="row"></div>
						<div class="row">
							<div class="col s12">
								<div class="right-align">
									<button class="waves-effect waves-light btn-large">Entrar</button>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col s12 right-align">
								<a href="#">Olvidé mi contraseña</a>
							</div>

							<div id="error"></div>
						</div>
					{{Form::close()}}
				</div>
			</div>
		</div>
	</div>

@stop