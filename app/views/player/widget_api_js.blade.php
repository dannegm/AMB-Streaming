(function() {
    var tv = document.getElementsByTagName('amb:video')[0];
    var width = tv.getAttribute('width');
    var uid = tv.getAttribute('uid');
    var typpe = tv.getAttribute('type');

    var iframe = document.createElement('iframe');
    iframe.src = '{{URL::asset("")}}' + typpe + '/' + uid + '/player';
    iframe.style.position = 'absolute';
    iframe.setAttribute('frameborder', '0');
    iframe.setAttribute('allowfullscreen', 'true');
    iframe.setAttribute('style', 'width: 100%; height: 100%; display: block;');

    var divContent = document.createElement('div');
    divContent.setAttribute('style', 'width: ' + width + 'px;');
    divContent.setAttribute('id', 'amb-stream');

    tv.appendChild(divContent);
    divContent.appendChild(iframe);

    function resize() {
        console.log(parseInt(divContent.offsetWidth));
        divContent.style.height = parseInt(divContent.offsetWidth * 0.5625) + 'px';
    }

    window.onresize = resize;
    resize();
})();