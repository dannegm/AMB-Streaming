var _ = (function (e) { return document.getElementById(e); });

var hostname = 'http://circovolador.dnn.im/';

var w_w = $("#iphoneCanvas").width(),
	w_h = $("#iphoneCanvas").height();
var n_childs_talleres = 1;
var n_childs_proyectos = 1;

var empty = '<article class="empty"><p>Nada por aquí :(</p></article>';

function resize () {
	w_w = $("#iphoneCanvas").width();
	w_h = $("#iphoneCanvas").height();
	nw_h = w_h - 37 - 20;

	$('#wrap, section, .tabhost article').css({
		'width': w_w,
		'height': nw_h
	});;

	$('.w, .info, .horaries').css({
		'width': w_w
	});

	// Cartelera

	$('#tab_cartelera').css({
		'width': w_w,
		'height': nw_h
	});
	$('#tab_cartelera article').css({
		'height': nw_h
	});

	// Talleres

	$('#tab_talleres').css({
		'width': w_w,
		'height': nw_h
	});
	$('#tab_talleres article').css({
		'height': nw_h
	});
	$('#tab_talleres .info').css({
		'width': w_w - 20
	});

	if (w_w > 700) {
		$('#tab_talleres article figure').css({
			'max-height': nw_h - 405
		});
	} else {
		$('#tab_talleres article figure').css({
			'max-height': nw_h - 305
		});
	}

	// Streaming

	$('#tab_stream').css({
		'width': 2 * w_w
	});
	$('.bgradio').css({
		'margin-top': (nw_h / 2) - (217 / 2) - 100
	});
	$('#canvas-tv').css({
		'margin-top': (nw_h / 2) - ($('#canvas-tv').height() / 2) - 100
	});

	// Proyectos
	var margin_proyectos = 5;
	if (w_w > 700) {
		margin_proyectos = 10;
	}

	$('#tab_proyectos').css({
		'width': n_childs_proyectos * w_w
	});
	$('#proyectos .galery').css({
		'margin-top': nw_h - (w_w / 3) + margin_proyectos
	});
	$('#proyectos .info').css({
		'bottom': w_w / 3 + (margin_proyectos * 2),
		'width': w_w - (parseInt($('#proyectos .info').css('padding-left')) * 2)
	});

	$('#proyectos h1').css({
		'bottom': (w_w / 3 + (margin_proyectos * 2)) + $('#proyectos .info').height() + (margin_proyectos * 5),
		'width': w_w - (parseInt($('#proyectos .info').css('padding-left')) * 2)
	});

	$('#proyectos .galery').css({
		'width': w_w
	});
	$('#proyectos .galery li').css({
		'width': (w_w / 3) - 20,
		'height': (w_w / 3) - 20
	});
}

function buildSlide (el) {
	var count_childs = $(el + ' article').length - 1;
	var art_actual = 0;
	var idd = $(el).attr('id');
	$('.pagin_indicator li:first-child').addClass('active');

	$('#' + idd + ' [rel="a0"]').removeClass('next').addClass('now');

	function slide2left () {
		if (art_actual < count_childs) {
			$('#' + idd + ' [rel="a' + art_actual + '"]').removeClass('now next').addClass('back');
			$('#' + idd + ' [rel="a' + (art_actual + 1) + '"]').removeClass('next back').addClass('now');

			art_actual++;

			$('.pagin_indicator[rel="' + idd + '"] li').removeClass('active');
			$('.pagin_indicator[rel="' + idd + '"] .d' + art_actual).addClass('active');
		}
	}
	function slide2right () {
		if (art_actual > 0) {
			$('#' + idd + ' [rel="a' + art_actual + '"]').removeClass('now back').addClass('next');
			$('#' + idd + ' [rel="a' + (art_actual - 1) + '"]').removeClass('next back').addClass('now');

			art_actual--;

			$('.pagin_indicator[rel="' + idd + '"] li').removeClass('active');
			$('.pagin_indicator[rel="' + idd + '"] .d' + art_actual).addClass('active');
		}
	}
	$(el).on('swipeleft', slide2left);
	$(el).on('swiperight', slide2right);
}

var _tMenu = 0;
function showSideMenu () {
	$('#menu').removeClass('hide');
	$('#warp').css('opacity', '0.4');
	_tMenu = 1;
}
function hideSideMenu () {
	$('#menu').addClass('hide');
	$('#warp').css('opacity', '1');
	_tMenu = 0;
}
function toggleMenu () {
	if (!_tMenu) {
		showSideMenu();
	} else {
		hideSideMenu();
	}
}

function regularEvents () {
	$('#toggleMenu').on('click', function() {
		toggleMenu();
	});
	$('#cartelera, #talleres, #streaming, #menu, header').on('swipedown', showSideMenu);
	$('#cartelera, #talleres, #streaming, #menu, header').on('swipeup', hideSideMenu);

}

function menu () {
	$('#menu a').click(function () {
		var to = $(this).attr('href');
		var title = $(this).attr('title');

		$('#warp section').hide();
		$(to).fadeIn();

		$('#sec_title').text(title);
		hideSideMenu();
		resize();
	});

	$('#warp').click(hideSideMenu);
}

// === Json ==============

function $cartelera () {
	$.getJSON(hostname + 'api/v2/eventos.json', function (resp) {
		$('#tab_cartelera').html('');
		var c = 0;

		if (resp.length > 0) {
			for (x in resp) {
				var evento = resp[x];
				evento.index = c;
				$('#tplEvento').tmpl(evento).appendTo('#tab_cartelera');
				$('#cartelera .pagin_indicator').append('<li class="d' + c + '" rel="' + evento.id + '"></li>');
				c++;
			}
			resize();
			buildSlide('#tab_cartelera');
		} else {
			$('#tab_cartelera').html(empty);
		}
	})
	.error(function () {
		$('#tab_cartelera').html(empty);
	});

	$(document).on('click', '.popEventos', function () {
		//$('#infoEventos').fadeIn();

		var mtop_t_pop = ((w_h / 2) - ($('#infoEventos article').height() / 2)) + 30;
		$('#infoEventos article').css({
			'margin-top': mtop_t_pop
		});
	});
}

function $talleres () {
	$.getJSON(hostname + 'api/v2/talleres.json', function (resp) {
		$('#tab_talleres').html('');
		var c = 0;

		if (resp.length > 0) {
			for (x in resp) {
				var taller = resp[x];
				taller.index = c;
				taller.content = taller.content.replace(/\\/ig, '');
				$('#tplTaller').tmpl(taller).appendTo('#tab_talleres');
				$('#talleres .pagin_indicator').append('<li class="d' + c + '" rel="' + taller.id + '"></li>');
				c++;
			}
			resize();
			buildSlide('#tab_talleres');
		} else {
			$('#tab_talleres').html(empty);
		}
	})
	.error(function () {
		$('#tab_talleres').html(empty);
	});

	$('.info_talleres').click(function () {
		//$('#infoTalleres').fadeIn();

		var mtop_t_pop = ((w_h / 2) - ($('#infoTalleres article').height() / 2)) + 30;
		$('#infoTalleres article').css({
			'margin-top': mtop_t_pop
		});
	});
}

function $streaming () {
	$.getJSON(hostname + 'api/v2/stream.json', function (r) {
		var radio = r.radio;
		var video = r.video;

		if (radio.status != "offline") {
			_('canvas-radio').src = radio.m3u8;

			var radioIsPlay = false;
			$('#play-radio').click(function () {
				if (!radioIsPlay) {
					_('canvas-radio').play();
				} else {
					_('canvas-radio').pause();
				}
			});

			_('canvas-radio').addEventListener('waiting', function () {
				$('#play-radio').removeClass('play pause').addClass('loading');
				radioIsPlay = false;
			});
			_('canvas-radio').addEventListener('playing', function () {
				$('#play-radio').removeClass('loading play').addClass('pause');
				radioIsPlay = true;
			});
			_('canvas-radio').addEventListener('pause', function () {
				$('#play-radio').removeClass('pause loading').addClass('play');
				radioIsPlay = false;
			});
			_('canvas-radio').addEventListener('error', function () {
				$('#play-radio').removeClass('pause loading').addClass('play');
				radioIsPlay = false;
			});


			function getTrackInfo() {
				$.ajax({
					type: 'GET',
					url: hostname + 'app/csong.php',
					contentType: 'text/plain; charset=utf-8',
					dataType: 'text',
					success: function(song) {
						if (song != "") {
							$('#actualSong').text(song);
						} else {
							$('#actualSong').text("Circo Volador Radio");
						}
					},
					error: function () {
						$('#actualSong').text("Circo Volador Radio");
					}
				});
			}
			getTrackInfo();

			var counter = 0;
	    	var ciclo = setInterval(function(){
	    		getTrackInfo();
	    		if( counter >= 20){
	    			clearInterval(ciclo);
	    			console.log(counter);
	    		}
	    		counter ++;
	    	}, 500);
		} else {

		}
	});

	/*
	function toRadio () {
		$('#tab_stream').css({
			'margin-left': 0
		});
		$('#toRadio').addClass('active');
		$('#toStream').removeClass('active');
		_('canvas-tv').pause();
	}

	function toStream () {
		$('#tab_stream').css({
			'margin-left': - (w_w)
		});
		$('#toStream').addClass('active');
		$('#toRadio').removeClass('active');
		_('canvas-radio').pause();
	}

	$('#toRadio').click(toRadio);
	$('#toStream').click(toStream);

	$('#tab_stream').on("swipeleft", toStream);
	$('#tab_stream').on("swiperight", toRadio);
	/**/
}

function $proyectos () {
	$.getJSON('http://graph.facebook.com/1407213609491588?fields=albums.fields(description,cover_photo,name,photos)', function (resp) {
		$('#tab_proyectos').html('');

		resp.albums.data.reverse();
		var c = 0;
		var albums = [];
		if (resp.albums.data.length > 0) {
			for (x in resp.albums.data) {
				var album = resp.albums.data[x];
				if (album.description) {
					albums.push(album);
					album.index = c;
					$('#tplProyecto').tmpl(album).appendTo('#tab_proyectos');
					c++;
				}
			}
			resize();
			buildSlide('#tab_proyectos');

			/*

			$('#proyectos article').on("swipeup", function () {
				$(this).animate({
					scrollTop: (nw_h - (w_w / 3) + 5)
				}, 100);
				$(this).children('.info').fadeOut();
				$(this).children('h1').fadeOut();
				$(this).children('.bgBlur').css({
					'-webkit-filter': 'blur(10px) brightness(0.3) !important;'
				});
			});
			$('#proyectos article').on("swipedown", function () {
				$(this).animate({
					scrollTop: 0
				}, 100);
				$(this).children('.info').fadeIn();
				$(this).children('h1').fadeIn();
				$(this).children('.bgBlur').css({
					'-webkit-filter': 'blur(10px) brightness(0.6) !important;'
				});
			});

			*/
		} else {
			$('#tab_proyectos').html(empty);
		}
	})
	.error(function () {
		$('#tab_proyectos').html(empty);
	});
}

// === Home ==============

function isLandscape () {
	_('canvas-tv').pause();
	_('canvas-radio').pause();

	$('#canvas-full').addClass('full');
	_('canvas-full').play();
}

function isPortrait () {
	_('canvas-full').pause();
	$('#canvas-full').removeClass('full');
}

function init () {
	FastClick.attach(document.body);

	resize();
	regularEvents();
	menu();

	$(window).resize(resize);
	/*
	$('.popup').click(function () {
		$(this).fadeOut();
	});*/

	$cartelera();
	$talleres();
	$proyectos();
	$streaming();

	$(window).on('orientationchange', function () {
		if (window.orientation == 0) {
			isPortrait();
		} else {
			isLandscape();
		}
	});

	document.onselectstart = function(){ return false; }
}
$(init);