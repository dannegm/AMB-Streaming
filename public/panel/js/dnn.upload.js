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

var $$ = function (e) { return document.getElementById(e); };

var upload = function (options) {
    options.start();

    var imgData = false, reader, picture, file = options.files[0], canUpload = false;
    if ( !!file.type.match(/image.*/) ) {
        if (!(file.size > options.maxSize) ) {
            if (window.FormData) { imgData = new FormData(); }
            if (window.FileReader) {
                reader = new FileReader();
                reader.onloadend = function (e) {
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
                reader.readAsDataURL(file);
            }
            if (imgData) {
                imgData.append(options.filename, file);
                imgData.append('group', options.group);
            }
        } else {
            options.error({
                code: 2,
                message: "La imagen es muy pesada"
            });
        }
    } else {
        options.error({
            code: 3,
            message: "Debes elegir una imagen"
        });
    }

    if (imgData) {
        $.ajax({
            url: options.url,
            type: 'POST',
            data: imgData,
            processData: false,
            contentType: false,
            xhr: options.xhr,
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
        $('#file_logo').val("");
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

var ondragenter = function (e) {
    e.preventDefault();
    var $dr = $(this);
    $dr.addClass('dragover');
},
ondragover = function(e) {
    e.preventDefault();
    var $dr = $(this);
    if(!$dr.hasClass("dragover"))
        $dr.addClass("dragover");
},
ondragleave = function(e) {
    e.preventDefault();
    var $dr = $(this);
    $dr.removeClass('dragover');
},
ondrop = function (e) {
    e.preventDefault();
    var $dr = $(this);
    $dr.removeClass('dragover');
};

$(function () {
    // Logo
    var input_logo = $('#file_logo');
    input_logo.on('change', function (e) {
        e.preventDefault();
        options_logo.files = this.files;
        upload( options_logo );
    });
    $('#droppeable_logo .openFile').on('click', function (e) {
        e.preventDefault();
        input_logo.trigger('click');
    });

    var holder_logo = $$('droppeable_logo');
    holder_logo.ondragenter = ondragenter;
    holder_logo.ondragover = ondragover;
    holder_logo.ondragleave = ondragleave;
    holder_logo.ondrop = function(e) {
        ondrop(e);
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
    $('#droppeable_cover .openFile').on('click', function (e) {
        e.preventDefault();
        input_cover.trigger('click');
    });

    var holder_cover = $$('droppeable_cover');
    holder_cover.ondragenter = ondragenter;
    holder_cover.ondragover = ondragover;
    holder_cover.ondragleave = ondragleave;
    holder_cover.ondrop = function(e) {
        ondrop(e);
        options_cover.files = e.dataTransfer.files;
        upload( options_cover );
    };
});





