@extends('appanel/template')

@section('content')
	<script src="{{URL::asset('/assets/player/js/jquery.countdown.min.js')}}"></script>
	<script>
	$(function () {
		$('#clock').countdown('{{$event->ended_at}}')
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

	<ol class="breadcrumb">
		<li><a href="{{route('appanel')}}">Inicio</a></li>
		<li><a href="{{route('appanel.events.index')}}">Eventos</a></li>
		<li>Información</li>
		<li class="active">{{$event->uid}}</li>
	</ol>

	<div class="row">
		<div class="col-md-12">
			<h3>{{$event->title}}</h3>
			@if($event->isLive())
			<p>
				<span class="label label-danger">En vivo</span>
				<code>Finaliza en <span id="clock"></span></code>
			</p>
			@endif
			<blockquote>
				<footer>Sku: {{$event->uid}}</footer>
			</blockquote>
		</div>
	</div>

	<div class="btn-toolbar" style="margin-bottom: 1em;">
		<a target="_blank" href="{{route('home.event', array('uid' => $event->uid, 'void' => urlencode($event->title)))}}" class="btn btn-primary btn-sm" role="button">Landing page</a>
		<a target="_blank" href="{{route('home.event', array('uid' => $event->uid, 'void' => urlencode($event->title)))}}?debug" class="btn btn-default btn-sm" role="button">Landing <b>modo debug</b></a>
		<a href="{{route('appanel.channels.view', array('uid' => $event->channel->uid))}}" class="btn btn-default btn-sm" role="button">Canal <b>{{$event->channel->name}}</b></a>

		@if(Auth::user()->permissions()->events->edit)
		<a href="{{route('appanel.events.edit', array('uid' => $event->uid))}}" class="btn btn-default btn-sm" role="button">Editar</a>
		@endif

		<a href="#" class="btn btn-default btn-sm" role="button" disabled="disabled">Ver estadísticas</a>

		@if($event->isLive())
			@if(Auth::user()->permissions()->events->edit)
			<a href="{{route('appanel.events.addhour', array('uid' => $event->uid))}}" class="btn btn-default btn-sm" role="button">Extender 1hr</a>
			<a href="{{route('appanel.events.finish', array('uid' => $event->uid))}}" class="btn btn-danger btn-sm" role="button">Terminar</a>
			@endif
		@else
			@if(Auth::user()->permissions()->events->delete)
			<a href="{{route('appanel.events.delete', array('uid' => $event->uid))}}" class="btn btn-danger btn-sm" role="button">Eliminar</a>
			@endif
		@endif
	</div>

	<div role="tabpanel">
		<ul class="nav nav-tabs">
			<li role="presentation" class="active"><a href="#code" aria-controls="code" role="tab" data-toggle="tab">Código</a></li>
			<li role="presentation"><a href="#access" aria-controls="access" role="tab" data-toggle="tab">Acceso</a></li>
			<li role="presentation"><a href="#preview" aria-controls="preview" role="tab" data-toggle="tab">Preview</a></li>
		</ul>

		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="code">
				<div class="row">
					<div class="col-md-12">
						<h5>Enlace a la plataforma</h5>
						<pre><a target="_blank" href="{{route('home.event', array('uid' => $event->uid, 'void' => urlencode($event->title)))}}">{{route('home.event', array('uid' => $event->uid, 'void' => urlencode($event->title)))}}</a></pre>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<div class="input-field extend">
							<h5>Código de inserción</h5>
							<pre class="copypaste">
&lt;script&gt;
(function() {
var sc=document.createElement("script");sc.type="text/javascript";sc.async=true;
sc.src="{{URL::asset('api/widget.js')}}";
var s=document.getElementsByTagName("script")[0];s.parentNode.insertBefore(sc,s)
})();
&lt;/script&gt;
&lt;amb:video uid="{{$event->uid}}" type="event"&gt;&lt;/amb:video&gt;</pre>
						</div>
					</div>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane" id="access">
				<div class="row">
					<div class="col-md-12">
						<h5>Información RTMP</h5>
						<blockquote style="font-size: 1em;">
							<dl class="dl-horizontal">
								<dt>Código</dt>
								<dd><code>{{$event->channel->rtmp}}</code></dd>
							</dl>
							<dl class="dl-horizontal">
								<dt>Stream</dt>
								<dd><code>{{$event->channel->rtmp_stream}}</code></dd>
							</dl>
							<dl class="dl-horizontal">
								<dt>Usuario</dt>
								<dd><code>{{$event->channel->rtmp_user}}</code></dd>
							</dl>
							<dl class="dl-horizontal">
								<dt>Contraseña</dt>
								<dd><code>{{$event->channel->rtmp_pass}}</code></dd>
							</dl>
						</blockquote>
					</div>
				</div>

				@if($event->isFinish())
				<div class="row">
					<div class="col-md-12">
						<h5>Información de evento grabado</h5>
						<blockquote style="font-size: 1em;">
							@if(!empty($event->ftp_host))
							<dl class="dl-horizontal">
								<dt>Host</dt>
								<dd><code>{{$event->ftp_host}}</code></dd>
							</dl>
							<dl class="dl-horizontal">
								<dt>Puerto</dt>
								<dd><code>{{$event->ftp_port}}</code></dd>
							</dl>
							<dl class="dl-horizontal">
								<dt>Usuario</dt>
								<dd><code>{{$event->ftp_user}}</code></dd>
							</dl>
							<dl class="dl-horizontal">
								<dt>Contraseña</dt>
								<dd><code>{{$event->ftp_pass}}</code></dd>
							</dl>
							@else
							<div class="alert alert-warning" role="alert">Aún no se han configurado los accesos FTP. 
								@if(Auth::user()->permissions()->events->edit)
								Configúralos <a href="{{route('appanel.events.edit', array('uid' => $event->uid))}}">aquí</a>
								@endif
							</div>
							@endif
							<dl class="dl-horizontal">
								<dt>VoD</dt>
								<dd><code>{{!empty($event->rtmp) ? $event->rtmp : 'RTMP no asignado'}}</code></dd>
							</dl>
						</blockquote>
					</div>
				</div>
				@endif
			</div>
			<div role="tabpanel" class="tab-pane" id="preview">
				<div class="row">
					<div class="col-lg-6 col-md-8 col-sm-12">

						<div class="btn-toolbar" style="margin-bottom: 1em;">
							<div class="btn-group" data-toggle="buttons">
								<label class="btn btn-default btn-sm active">
									<input type="radio" name="options" value="mode_preview" id="mode_preview" autocomplete="off" checked> Preview
								</label>
								<label class="btn btn-default btn-sm">
									<input type="radio" name="options" value="mode_normal" id="mode_normal" autocomplete="off"> Normal
								</label>
							</div>
						</div>

						<script>
						$(function () {
							$('[name=options]').change(function(event) {
								switch($('[name=options]:checked').val()) {
									case 'mode_preview':
										$('#player').attr(
											'src',
											"{{route('player.event', array('uid' => $event->uid))}}?debug&muted"
										);
										break;
									case 'mode_normal':
										$('#player').attr(
											'src',
											"{{route('player.event', array('uid' => $event->uid))}}?muted"
										);
										break;
								}
							});
						});
						</script>

						<div class="thumbnail">
							<div class="embed-responsive embed-responsive-16by9">
								<iframe id="player" src="{{route('player.event', array('uid' => $event->uid))}}?debug&muted" frameborder="0" allowfullscreen="true"></iframe>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop