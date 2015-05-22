$(document).ready(function(){
	$('.login').submit(function(){
		console.log($(this).serialize());
		$.ajax({
			type:'POST',
			url:$(this).attr('action'),
			data:$(this).serialize(),
		})
		.done(function(msg){
			if(msg == 'login exitoso'){
				window.location = 'appanel/index';
			}else{
				$('#error').text('La contraseña o el nombre de usuario son incorrectos');
			}
		});
		return false;
	});

	$('.delete').click(function(e){
		e.preventDefault();
		$this = $(this);
		swal({
			title: '¿Estás seguro?',
			text: 'Esta acción no puede deshacerse',
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: '¡¡Perfecto!!',
			closeOnConfirm: true,
		}, function(){
			window.location = $this.attr('href');
		});
	});

	//destacados específicos
	$('.destacados').sortable({
		revert: true,
		stop: function(event,ui){
			id = $(this).attr('id');
			saveDestacados(id);
		}
	});
	
	var new_id = 20;

	$('.drag').draggable({
		cursor: 'move',
		revert: 'invalid',
		helper: function () { 
			var cloned = $(this).clone();
			cloned.attr('id', (++new_id).toString());
			return cloned;
		},
		distance: 20
	});

	$('.destacados').droppable({
		hoverClass: 'ui-state-active',
		tolerance: 'pointer',

		accept: function (event, ui) {
			return true;
		},
		drop: function (event, ui) {
			lis = $('.destacados > div').length;
			if(lis < 5){
				var obj;
				id = $(ui.helper).data('item');
				if(id != undefined){
					img = $(ui.helper).find('.activator').attr('src');
					title = $(ui.helper).find('.card-image .card-title').text();

					el = $('<div>').addClass('list').attr('data-id', id).css({
						'background-size':'cover',
						'background':'url('+img+') center',
					});
					el.append($('<h3>').text(title));
					el.append($('<span>').addClass('remove').text('x'));

					$(this).append(el);
				}
			}

			id = $(this).attr('id');

			$(this).find('h5').hide();

			saveDestacados(id);
		}
	});

	function saveDestacados(id){
		if($('#'+id).hasClass('video_d')){
			url = $('.destacados.video_d').data('send');
			elements = $('.destacados.video_d > div');
		}else{
			url = $('.destacados.nota_d').data('send');
			elements = $('.destacados.nota_d > div');
		}

		console.log(url);

		obj = {
			"destacados":[{
				"1":{},
				"2":{},
				"3":{},
				"4":{},
				"5":{}
			}]
		};
		i = 1;
		$.each(elements, function(key, value){
			div = $(value);
			id = div.attr('data-id');
			if (id != undefined){
				pos = i;
				obj.destacados[pos] = id;
				i++;
				console.log(obj);
			}
		});
		$.ajax({
			type: "POST",
			url: url,
			data: {'positions':obj},
			success: function(){},
			dataType: "json",
		});
	}

	//destacados generales
	$('.destacadosg').sortable({
		revert: true,
		stop: function(event,ui){
			id = $(this).attr('id');
			saveDestacadosg(id);
		}
	});
	
	var new_id = 20;

	$('.drag').draggable({
		cursor: 'move',
		revert: 'invalid',
		helper: function () { 
			var cloned = $(this).clone();
			cloned.attr('id', (++new_id).toString());
			return cloned;
		},
		distance: 20
	});

	$('.destacadosg').droppable({
		hoverClass: 'ui-state-active',
		tolerance: 'pointer',

		accept: function (event, ui) {
			return true;
		},
		drop: function (event, ui) {
			lis = $('.destacadosg > div').length;
			if(lis < 5){
				var obj;
				id = $(ui.helper).data('item');
				if(id != undefined){
					img = $(ui.helper).find('.activator').attr('src');
					title = $(ui.helper).find('.card-image .card-title').text();

					el = $('<div>').addClass('list').attr('data-id', id).css({
						'background-size':'cover',
						'background':'url('+img+') center',
					});
					el.append($('<h3>').text(title));
					el.append($('<span>').addClass('removeg').text('x'));

					$(this).append(el);
				}
			}

			id = $(this).attr('id');

			$(this).find('h5').hide();

			saveDestacadosg(id);
		}
	});

	function saveDestacadosg(id){
		url = url = $('.destacadosg').data('send');
		elements = $('.destacadosg > div');

		if($('#'+id).hasClass('video_d')){
			typeDefault = 'video';
		}else{
			typeDefault = 'nota';
		}

		obj = {
			"destacados":[{
				"1":{},
				"2":{},
				"3":{},
				"4":{},
				"5":{}
			}]
		};
		i = 1;
		$.each(elements, function(key, value){
			div = $(value);
			id = div.attr('data-id');
			type = div.attr('data-type');

			if (type == undefined){
				type = typeDefault;
			}

			if (id != undefined){
				pos = i;
				obj.destacados[pos] = {id:id,type:type};
				i++;
			}
		});
		$.ajax({
			type: "POST",
			url: url,
			data: {'positions':obj},
			success: function(){},
			dataType: "json",
		});
	}

	$(document).on('click', '.remove', function(e){
		e.preventDefault()
		parent = $(this).parent();
		id = parent.parent().attr('id');
		parent.remove();
		console.log(id);
		saveDestacados(id);
	});

	$(document).on('click', '.removeg', function(e){
		e.preventDefault()
		parent = $(this).parent().remove();
		id = $(this).closest('.card-panel').attr('id');
		console.log(id);
		saveDestacadosg(id);
	});

});