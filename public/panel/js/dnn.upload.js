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
    xhr: function () {
        var xhr = new window.XMLHttpRequest();
        xhr.upload.addEventListener('progress', function(p) {
            var percentComplete = p.loaded / p.total;
            var percent = parseFloat(Math.round((percentComplete * 100)));
        }, false);
        return xhr;
    },
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




