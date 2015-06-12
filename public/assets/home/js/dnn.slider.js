// Slider de Proceso

var actual = 1;
var interval;
var time = 10000;

function procesoNext () {
    var items = $('#slider .sld');
    var count = items.length;
    if (actual <= count) {
        $('#step_' + actual).removeClass('now').removeClass('next').addClass('back');
        $('#step_' + (actual + 1)).removeClass('next').addClass('now');

        $('#dots li').removeClass('active');
        $('#dot_' + (actual + 1)).addClass('active');

        actual++;
    }
}

function procesoBack () {
    if (actual > 1) {
        $('#step_' + actual).removeClass('now').removeClass('back').addClass('next');
        $('#step_' + (actual - 1)).removeClass('back').addClass('now');

        $('#dots li').removeClass('active');
        $('#dot_' + (actual - 1)).addClass('active');

        actual--;
    }
}

function procesoToStep (step) {
    actual = step;
    $('#slider .sld').removeClass('back').removeClass('now').addClass('next');
    $('#step_' + step).removeClass('next').addClass('now');

    $('#dots li').removeClass('active');
    $('#dot_' + step).addClass('active');
}

function clockSlide () {
    var items = $('#slider .sld');
    var count = items.length;
    if (actual == count) {
        procesoToStep(1);
    } else {
        procesoNext();
    }
}

function init () {
    $('[data-step]').click(function() {
        procesoToStep( $(this).data('step') );
        window.clearInterval();
        interval = setInterval(clockSlide, time);
    });

    interval = setInterval(clockSlide, time);
}

$(document).ready(init);























