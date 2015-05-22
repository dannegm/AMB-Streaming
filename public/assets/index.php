<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=320, user-scalable=no" />

	<title>Circo Volador</title>

	<link rel="stylesheet" href="css/default.css" />

	<script src="js/jquery_min.js"></script>
	<script src="js/jquery_template.js"></script>
	<script src="js/jquery_event_move.js"></script>
	<script src="js/jquery_event_swipe.js"></script>
	<script src="js/fastclick_min.js"></script>
	<script src="js/script.js"></script>
</head>
<body>

	<!-- templating -->
	<script id="tplEvento" type="text/x-jquery-tmpl">
		<article id="${ id }" rel="a${index}" class="next">
			<figure style="background-image: url(${ picture });"></figure>
			<h1>${ artista }</h1>
			<span class="date">${ presentacion }</span>
			<div class="buttons">
				<span class="price"><span>Precio: $ ${ price }</span></span>
				<button class="popEventos"><i class="icon-ticket"></i> Comprar</button>
			</div>
		</article>
	</script>
	<script id="tplTaller" type="text/x-jquery-tmpl">
		<article id="${ id }" rel="a${index}" class="next" style="background-image: url(${ imgsrc_blur });">
			<figure>
				<img src="${ imgsrc }" />
			</figure>
			<h1>${ title }</h1>
			<ul class="horaries">
				{{each(i,val) horario}}
				<li>
					<span class="group">Grupo ${i + 1}</span>
					<span class="schedule">${val.horario}</span>
				</li>
				{{/each}}
			</ul>
			<p class="info">
				${ content }
			</p>
		</article>
	</script>
	<script id="tplProyecto" type="text/x-jquery-tmpl">
		<article id="${ id }" rel="a${index}" class="next">
			<div class="bgBlur" style="background-image: url(http://graph.facebook.com/${ cover_photo }/picture);"></div>
			<h1>${ name }</h1>
			<p class="info">
				${ description }
			</p>
			<ul class="galery">
				{{each(i,val) photos.data}}
				<li>
					<img src="http://graph.facebook.com/${ val.id }/picture" />
				</li>
				{{/each}}
			</ul>
		</article>
	</script>

<!--
	<video id="canvas-full" src="http://wms.tecnoxia.com:1935/8294/8294/playlist.m3u8" controls webkit-playsinline></video>
-->

	<div class="iOS"><div></div></div>
	<header>
		<ul>
			<li id="sec_title" class="active">Cartelera</li>
		</ul>
		<button id="toggleMenu"></button>
	</header>
	<nav id="menu" class="hide">
		<ul>
			<li><a href="#cartelera" title="Cartelera">
				<img src="img/menu_cartelera.png" />
				<span>cartelera</span>
			</a></li>
			<li><a href="#talleres" title="Talleres">
				<img src="img/menu_talleres.png" />
				<span>talleres</span>
			</a></li>
			<li><a href="#streaming" title="Streaming">
				<img src="img/menu_streaming.png" />
				<span>streaming</span>
			</a></li>
			<li><a href="#proyectos" title="Proyectos">
				<img src="img/menu_proyectos.png" />
				<span>proyectos</span>
			</a></li>
		</ul>
	</nav>

	<div id="warp">

	<!-- Cartelera -->
		<section id="cartelera" style="display: block;">
			<div class="popup" id="infoEventos">
				<article>
					<h1>Horarios de taquilla</h1>
					<p>Lunes a viernes de <strong>10:00 a 19:00 hrs.</strong></p>
					<p>Sábados de <strong>11:00 a 14:00 hrs.</strong></p>
					<img src="img/mapa.png" />
					<p class="rojo center">Calzada de la viga, #146, Col. Jamaica, México D.F.</p>
					<a class="btn" href="tel:57409012">57409012</a>
				</article>
			</div>
			<div id="tab_cartelera" class="tabhost">
				<img class="loading" src="img/preloader.gif" />
			</div>
			<ul class="pagin_indicator" rel="tab_cartelera">
			</ul>
		</section>

	<!-- Talleres -->
		<section id="talleres">
			<div class="popup" id="infoTalleres">
				<article>
					<h1>Requisitos de inscripción</h1>
					<ul>
						<li>$30.00 por inscripción y pago de credencial.</li>
						<li>Traer dos fotos tamaño infantil, colo o blanco y negro.</li>
						<li>Pago del primer mes de colegiatura.</li>
						<li>Que haya cupo en el taller y/o grupo seleccionado.</li>
						<li>Diseño Gráfico Básico sólo acepta seis alumnos por grupo.</li>
					</ul>
					<p class="azul center">Para mayores informes ponte en contacto con nosotros:</p>
					<p class="rojo center">Calzada de la viga, #146, Col. Jamaica, México D.F.</p>
					<a class="btn" href="tel:57409012">57409012</a>
				</article>
			</div>

			<button class="info_talleres">
				<i class="icon-info"></i>
				<span>Información</span>
			</button>
			<div id="tab_talleres" class="tabhost">
				<img class="loading" src="img/preloader.gif" />
			</div>
			<ul class="pagin_indicator" rel="tab_talleres">
			</ul>
		</section>

	<!-- Streaming -->
		<section id="streaming">
			<div id="tab_stream" class="tabhost">
				<article>
					<h1>CIRCO VOLADOR RADIO</h1>
					<video id="canvas-radio" webkit-playsinline></video>
					<div class="bgradio">
						<button id="play-radio" class="play"></button>
					</div>
				</article>
				<article>
					<h1>CIRCO VOLADOR TV</h1>
					<video id="canvas-tv" webkit-playsinline></video>
					<button id="play-tv" class="play"></button>
				</article>
			</div>
			<div class="toggle">
				<!--
				<button id="toRadio" class="active">Radio</button>
				<button id="toStream">T.V.</button>
				-->
				<span class="badge">Ahora suena</span>
				<span id="actualSong">Circo Volador Radio</span>
			</div>
		</section>

	<!-- Proyectos -->
		<section id="proyectos">
			<div id="tab_proyectos" class="tabhost">
				<img class="loading" src="img/preloader.gif" />
			</div>
		</section>

	</div>

</body>
</html>