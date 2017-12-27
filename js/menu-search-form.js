function getCenterOffset(parentHeight, childHeight) {
    return (parentHeight / 2) - (childHeight / 2);
}

function searchFieldShowHandler(jqSearchButton) {
    var jqSearchForm = jqSearchButton.data('searchForm');
    
    jqSearchForm.css('visibility', 'hidden');
    jqSearchForm.css('position', 'absolute');
    
    jqSearchButton.css('position', 'relative');
    
    jqSearchButton.prepend(jqSearchForm);
    
    jqSearchForm.css('right', jqSearchButton.outerWidth(true) + 'px');
    jqSearchForm.css('top', getCenterOffset(jqSearchButton.outerHeight(true), jqSearchForm.outerHeight(true)) + 'px');
    jqSearchForm.css('z-index', '10');
    
    jqSearchForm.css('display', 'none');
    jqSearchForm.css('visibility', '');
    
    jqSearchForm.animate({width: 'show'});
    
    jqSearchButton.find('.search-field').focus();
}

function searchFieldHideHandler(jqSearchButton) {
    var jqSearchForm = jqSearchButton.data('searchForm');
    
    jqSearchForm.animate({ width: 'hide' }, {
        always: function() {
            jqSearchForm.detach();
            
            jqSearchButton.css('position', '');
            jqSearchForm.css('display', '');
            jqSearchForm.css('position', '');
    
            jqSearchForm.css('right', '');
            jqSearchForm.css('top', '');
            jqSearchForm.css('z-index', '');
        }
    });
}

function attachFieldListeners(jqSearchButton) {
    var jqSearchForm = jqSearchButton.data('searchForm');
    
    jqSearchForm.find('.search-field').on({
        keyup: searchFieldKeyHandler.bind(this, jqSearchButton),
        blur: searchFieldBlurHandler.bind(this, jqSearchButton)
    });
    
    jqSearchForm.on({
        submit: searchFieldSubmitHandler.bind(this, jqSearchButton)
    });
}

function removeFieldListeners(jqSearchButton) {
    var jqSearchForm = jqSearchButton.data('searchForm');
    
    jqSearchForm.find('.search-field').off();
    jqSearchForm.off();
}

function searchFieldClickHandler(evt) {
    var jqSearchButton = $(this);
    var jqSearchForm = jqSearchButton.data('searchForm');
    
    if (!(jqSearchForm.is(evt.target) || jqSearchForm.find(evt.target).length)) {
        if (jqSearchForm.is(':visible')) {
            if (jqSearchForm.find('.search-field').val() === '') {
                return;
            } else {
                jqSearchForm.find('.search-form').submit();
            }
        } else {
            attachFieldListeners(jqSearchButton);
            
            searchFieldShowHandler(jqSearchButton);
        }
    }
    
    evt.preventDefault();
}

function searchFieldKeyHandler(jqSearchButton, evt) {
    if (evt.which == 27) { //Esc key
        removeFieldListeners(jqSearchButton);
    
        searchFieldHideHandler(jqSearchButton);
    }
}

function searchFieldBlurHandler(jqSearchButton, evt) {
    removeFieldListeners(jqSearchButton);
    
    searchFieldHideHandler(jqSearchButton);
}

function searchFieldSubmitHandler(jqSearchButton, evt) {
    removeFieldListeners(jqSearchButton);
    
    searchFieldHideHandler(jqSearchButton);
}

$(document).ready(function() {
    var searchButton = $('.menu-search-button');
    
    var searchForm = searchButton.find('.menu-search-form').clone();
    searchForm.detach();
    
    searchForm.find('.search-submit').remove();
    
    searchForm.find('label').css('margin', '0');
    
    searchForm.addClass('js-menu-search-form');
    
    searchButton.data('searchForm', searchForm);
    
    searchButton.click(searchFieldClickHandler);
});