/**
options = {
    url: url,
    filename: 'file',
    group: 'group',
    files: files,
    maxSize: 8 * 1024 * 1024,
    maxWidth: 1920,
    start: function (true) {},
    process: function (picture) {},
    error: function ({
            code: 1,
            message: msg
        }) {},
    xhr: function () {},
    success: function (response) {}
}
*/

/* Usando drag&drop */
var $$ = function (e) { return document.getElementById(e); };

var upload = function (options) {
    options.start();

    // Inicializamos variables
    var imgData = false, reader, picture, file = options.files[0], canUpload = false;;
    // Comprobamos que el archivo recibido sea una imagen
    if ( !!file.type.match(/image.*/) ) {
        // #mega * #kilo * #byte
        if (!(file.size > options.maxSize) ) {
            // Creamos un formulario
            if (window.FormData) { imgData = new FormData(); }
            if (window.FileReader) {
                // Creamos un archivo a partir de la lectura del input
                reader = new FileReader();
                // Cuando el archivo esté cargado ...
                reader.onloadend = function (e) {
                    // Obtenemos su resultado y lo almacenamos
                    picture = e.target.result;

                    var tmpimg = document.createElement('img');
                    tmpimg.src = picture;

                    if (tmpimg.width > options.maxWidth) {
                        alert('La imagen es muy grande');
                        options.error({
                            code: 1,
                            message: "La imagen es muy grande"
                        });
                    }
                    options.process(picture);
                };
                // Leemos el archivo
                reader.readAsDataURL(file);
            }
            // Anexamos el archivo al formulario con name="file"
            if (imgData) {
                imgData.append(options.filename, file);
                imgData.append('group', options.group);
            }
        } else {
            options.error({
                code: 1,
                message: "La imagen es muy pesada"
            });
        }
    } else {
        options.error({
            code: 1,
            message: "Debes elegir una imagen"
        });
    }

    // Si alrchivo está listo
    if (imgData) {
        // Creamos petició AJAX
        $.ajax({
            // Ruta a enviar el formulario
            url: options.url,
            // Método de la petición
            type: 'POST',
            // Datos del formulario
            data: imgData,
            // Otros ajustes
            processData: false,
            contentType: false,
            // Evento que regresa el porcentaje de subida
            xhr: options.xhr,
            // Evento cuando se terminó de subir la imagen
            success: options.success
        });
    }
};

options_logo = {
    url: 'http://ambmultimedia.dnn.im/picture/upload',
    filename: 'file',
    group: 'Logo',
    maxSize: 8 * 1024 * 1024,
    maxWidth: 720,
    start: function () {
    },
    process: function () {
        $('#droppeable_logo .options').hide();
    },
    error: function (error) {
        console.log(error.message);
    },
    xhr: function () {
        var xhr = new window.XMLHttpRequest();
        xhr.upload.addEventListener('progress', function(p) {
            var percentComplete = p.loaded / p.total;
            var percent = parseFloat(Math.round((percentComplete * 100)));
            $('#droppeable_logo .progress_front').css('width', percent + '%');
        }, false);
        return xhr;
    },
    success: function (response) {
        $('#droppeable_logo .progress_front').css('width', '0');
        $('#pic_logo').val(response.id);
        $('.options').show();
        $('#droppeable_logo').css({
            'background-image': "url('" + response.pic + "')"
        });
    }
}
options_cover = {
    url: 'http://ambmultimedia.dnn.im/picture/upload',
    filename: 'file',
    group: 'Background',
    maxSize: 8 * 1024 * 1024,
    maxWidth: 1920,
    start: function () {
    },
    process: function () {
        $('#droppeable_cover .options').hide();
    },
    error: function (error) {
        console.log(error.message);
    },
    xhr: function () {
        var xhr = new window.XMLHttpRequest();
        xhr.upload.addEventListener('progress', function(p) {
            var percentComplete = p.loaded / p.total;
            var percent = parseFloat(Math.round((percentComplete * 100)));
            $('#droppeable_cover .progress_front').css('width', percent + '%');
        }, false);
        return xhr;
    },
    success: function (response) {
        $('#droppeable_cover .progress_front').css('width', '0');
        $('#pic_cover').val(response.id);
        $('#droppeable_cover .options').show();
        $('#droppeable_cover').css({
            'background-image': "url('" + response.pic + "')"
        });
    }
}

$(function () {
    // Logo
    var input_logo = $('#file_logo');
    input_logo.on('change', function (e) {
        e.preventDefault();
        options_logo.files = this.files;
        upload( options_logo );
    });
    var btnOpenFile_logo = $('#droppeable_logo .openFile');
    btnOpenFile_logo.on('click', function (e) {
        e.preventDefault();
        input_logo.trigger('click');
    });

    var holder_logo = $$('droppeable_logo');

    holder_logo.ondragenter = function (e) {
        e.preventDefault();
        var $dr = $(this);
        $dr.addClass('dragover');
    };
    holder_logo.ondragover = function(e) {
        e.preventDefault();
        var $dr = $(this);
        if(!$dr.hasClass("dragover"))
            $dr.addClass("dragover");
    };
    holder_logo.ondragleave = function(e) {
        e.preventDefault();
        var $dr = $(this);
        $dr.removeClass('dragover');
    };
    holder_logo.ondrop = function(e) {
        e.preventDefault();
        var $dr = $(this);
        $dr.removeClass('dragover');

        options_logo.files = e.dataTransfer.files;
        upload( options_logo );
    };

    // Cover
    var input_cover = $('#file_cover');
    input_cover.on('change', function (e) {
        e.preventDefault();
        options_cover.files = this.files;
        upload( options_cover );
    });
    var btnOpenFile_cover = $('#droppeable_cover .openFile');
    btnOpenFile_cover.on('click', function (e) {
        e.preventDefault();
        input_cover.trigger('click');
    });

    var holder_cover = $$('droppeable_cover');

    holder_cover.ondragenter = function (e) {
        e.preventDefault();
        var $dr = $(this);
        $dr.addClass('dragover');
    };
    holder_cover.ondragover = function(e) {
        e.preventDefault();
        var $dr = $(this);
        if(!$dr.hasClass("dragover"))
            $dr.addClass("dragover");
    };
    holder_cover.ondragleave = function(e) {
        e.preventDefault();
        var $dr = $(this);
        $dr.removeClass('dragover');
    };
    holder_cover.ondrop = function(e) {
        e.preventDefault();
        var $dr = $(this);
        $dr.removeClass('dragover');

        options_cover.files = e.dataTransfer.files;
        upload( options_cover );
    };
});





