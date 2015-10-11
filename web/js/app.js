window.resizeElements = function() {

    //sidebar
    $('.app-sidebar').css('height', function() {
        var navbarHeight = $('#app-navbar').innerHeight();

        return $(window).innerHeight() - navbarHeight - 1;
    });

};

$(document).ready(function() {

    $('.app-sidebar ul > li').click(function(e) {
        e.preventDefault();

        var href = $(this).data('href');

        window.location.href = href;
    });

    $(window).resize(function() {
        window.resizeElements();
    });

    window.resizeElements();

});
