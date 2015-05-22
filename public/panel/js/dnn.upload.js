var upload = function (files) {
    $('.options').hide();
    $('.response').show();

    // Inicializamos variables
    var imgData = false, reader, picture, file = files[0], canUpload = false;;
    // Comprobamos que el archivo recibido sea una imagen
    if ( !!file.type.match(/image.*/) ) {
        // #mega * #kilo * #byte
        if (!(file.size > (8 * 1024 * 1024)) ) {
            // Creamos un formulario
            if (window.FormData) { imgData = new FormData(); }
            if (window.FileReader) {
                // Creamos un archivo a partir de la lectura del input
                reader = new FileReader();
                // Cuando el archivo esté cargado ...
                reader.onloadend = function (e) {
                    // Obtenemos su resultado y lo almacenamos
                    picture = e.target.result;
                    console.log(e);

                    var tmpimg = document.createElement('img');
                    tmpimg.src = picture;

                    if (tmpimg.width > 1920) {
                        alert('La imagen es muy grande');
                    }
                    $('.response').append('<h1 style="color:yellow;text-align:center;font-size:20px">Procesando...</h1>');
                };
                // Leemos el archivo
                reader.readAsDataURL(file);
            }
            // Anexamos el archivo al formulario con name="file"
            if (imgData) { imgData.append('file', file); }
        } else {
            alert("La imagen es muy pesada");
        }
    } else {
        alert("Debes elegir una imagen");
    }

    // Si alrchivo está listo
    if (imgData) {
        // Creamos petició AJAX
        $.ajax({
            // Ruta a enviar el formulario
            url: $('#ajaxdrop').data('upload'),
            // Método de la petición
            type: 'POST',
            // Datos del formulario
            data: imgData,
            // Otros ajustes
            processData: false,
            contentType: false,
            // Evento que regresa el porcentaje de subida
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener('progress', function(p) {
                    var percentComplete = p.loaded / p.total;
                    var percent = parseFloat(Math.round((percentComplete * 100)));

                    $('#uploadStatus').css('width', percent + '%');
                }, false);
                return xhr;
            },
            // Evento cuando se terminó de subir la imagen
            success: function(resp) {
                console.log(resp);
                $('.response').remove('h1');
                $('.response').hide();
                $('.pic').val(resp.picabs);
                $('.urlcover').val(resp.pic);
                $('.options').show();
                $('#droppeable').css({
                    'background-image': "url('" + resp.picabs + "')",
                });
            }
        });
    }
};


/* Uso */
/* Con un formulario normal */
$(function () {
    var input = $('[type="file"]');
    input.on('change', function (e) {
        e.preventDefault();
        upload( this.files );
    });

    /* Con un botón secundario */

    var btnOpenFile = $('.openFile');
    btnOpenFile.on('click', function (e) {
        e.preventDefault();
        input.trigger('click');
    });

    /* Usando drag&drop */
    var $$ = function (e) { return document.getElementById(e); };

    var holder = $$('droppeable');

    var onDragEnter = function (e) {
        e.preventDefault();
        var $dr = $(this);
        $dr.addClass('dragover');
    },
    onDragOver = function(e) {
        e.preventDefault();
        var $dr = $(this);
        if(!$dr.hasClass("dragover"))
            $dr.addClass("dragover");
    },
    onDragLeave = function(e) {
        e.preventDefault();
        var $dr = $(this);
        $dr.removeClass('dragover');
    },
    onDrop = function(e) {
        e.preventDefault();
        var $dr = $(this);
        $dr.removeClass('dragover');

        console.log(e);
        upload( e.dataTransfer.files );
    };

    holder.ondragenter = onDragEnter;
    holder.ondragover = onDragOver;
    holder.ondragleave = onDragLeave;
    holder.ondrop = onDrop;
});





