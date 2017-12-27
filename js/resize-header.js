function resizeHeader(jqHeader, jqContainer) {
    var targetWidth = jqContainer.width();
    var headerWidth = jqHeader.prop('scrollWidth');
    var headerFontSize = Number.parseFloat(jqHeader.css('font-size'));
    
    var targetFontSize = targetWidth * (headerFontSize/headerWidth);
    
    jqHeader.css('font-size', targetFontSize + 'px');
    
    if (!(jqHeader.hasClass('js-resize'))) {
        jqHeader.data('initialSize', headerWidth);
        jqHeader.addClass('js-resize');
    }
}

function checkHeaderOverflow(jqHeader, jqContainer) {
    if (jqHeader.hasClass('js-resize')) {
        return jqHeader.data('initialSize') > jqContainer.width();
    } else {
        return jqHeader.prop('scrollWidth') > jqContainer.width();
    }
}

function removeCssProperties(jqHeader) {
    jqHeader.css('font-size', '');
    jqHeader.removeData('initialSize');
    jqHeader.removeClass('js-resize');
}

function resizeHandler(evt) {
    var jqHeader = $('.site-branding');
    var jqContainer = $('.site');
    
    if (checkHeaderOverflow(jqHeader, jqContainer)) {
        resizeHeader(jqHeader, jqContainer);
    } else {
        if (jqHeader.hasClass('js-resize')) {
            removeCssProperties(jqHeader);
        }
    }
}

function generateThrottler(func, wait) {
    //Improvement: add immediate and edge triggers
    var counter = {timeout: null};
    
    return function() {
        if (counter.timeout == null) {
            counter.timeout = setTimeout(function(count, args) {
                counter.timeout = null;
                
                func.apply(this, args);
            }.bind(this, counter, arguments), wait)
        }
    }
}

$(document).ready(function() {
    $(window).resize(generateThrottler(resizeHandler, 66));
    
    resizeHandler.apply(this, arguments);
})