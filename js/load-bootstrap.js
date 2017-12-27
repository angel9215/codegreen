function convertPostNavigation(nav) {
    var jqNav = $(nav);
    
    var previousLink = jqNav.find('.nav-previous a');
    var nextLink = jqNav.find('.nav-next a');
    
    var bootstrapPager = $('<ul class="pager">');
    
    if (previousLink.length > 0) {
        previousLink = $('<li class="previous">').append(previousLink);
        
        bootstrapPager.append(previousLink);
    }
    
    if (nextLink.length > 0) {
        nextLink = $('<li class="next">').append(nextLink);
        
        bootstrapPager.append(nextLink);
    }
    
    if (bootstrapPager.children().length > 0) {
        jqNav.removeAttr('role');
        
        jqNav.empty();
        jqNav.append(bootstrapPager);
    }
}

function convertSitePagination(nav) {
    var jqNav = $(nav);
    
    var pageLinks = jqNav.find('.nav-links > *');
    
    if (pageLinks.length > 0) {
        var currentPage = pageLinks.filter('.current');
        
        pageLinks.removeAttr('class');
        
        var bootstrapPagination = $('<ul class="pagination">');
        
        for (var i = 0; i < pageLinks.length; i++) {
            bootstrapPagination.append($('<li>').append(pageLinks[i]));
        }
        
        currentPage.parent().addClass('active');
        
        jqNav.empty();
        jqNav.append(bootstrapPagination);
    }
}

function convertCommentForm(form) {
    var jqForm = $(form);
    
    jqForm.removeClass('css-comment-form');
    
    jqForm.find('.logged-in-as, .must-log-in').wrapInner('<p class="help-block">');
    
    jqForm.find('.comment-notes > span').each(function(idx, ele) {
        var jqSpan = $(ele);
        
        jqSpan.replaceWith($('<p class="help-block ' + jqSpan.attr('class') + '">').append(jqSpan.contents()));
    });
    
    jqForm.find('> p').each(function(idx, ele) {
        var jqP = $(ele);
        
        jqP.replaceWith($('<div class="form-group ' + jqP.attr('class') + '">').append(jqP.contents()));
    });
    
    jqForm.find('input, textarea').not('[type=submit]').addClass('form-control');
}

$(document).ready(function() {
    //Convert tables into bootstrap tables in content
    $('.content-area table').addClass('table-striped table-bordered');
    
    //Convert buttons to bootstrap buttons
    $('input[type="button"], input[type="submit"], button').addClass('btn btn-default');
    
    //Replace post navigation with bootstrap pager
    $('.post-navigation').each(function(idx, ele) {convertPostNavigation(ele);});
    
    //Replace pagination with bootstrap pagination
    $('.wp-pagination').each(function(idx, ele) {convertSitePagination(ele)});
    
    //Replace comment form with bootstrap form
    $('.comment-form').each(function(idx, ele) {convertCommentForm(ele)});
});