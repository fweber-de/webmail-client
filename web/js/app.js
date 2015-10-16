window.resizeElements = function() {

    //sidebar
    $('.app-sidebar').css('height', function() {
        var navbarHeight = $('#app-navbar').innerHeight();

        return $(window).innerHeight() - navbarHeight - 1;
    });

    //elements
    $('.app-elements').css('height', function() {
        var navbarHeight = $('#app-navbar').innerHeight();

        return $(window).innerHeight() - navbarHeight - 1;
    });

    //detail
    $('.app-detail').css('height', function() {
        var navbarHeight = $('#app-navbar').innerHeight();

        return $(window).innerHeight() - navbarHeight - 1;
    });

};

$(document).ready(function() {

    //page sections
    var section1 = $('#current-section-1').html();
    var section2 = $('#current-section-2').html();
    var section3 = $('#current-section-3').html();

    //sidebar click
    $('.app-sidebar ul > li').click(function(e) {
        e.preventDefault();

        var href = $(this).data('href');

        window.location.href = href;
    });

    //navbar highlights
    $('#nl-' + section1).addClass('active');

    //sidebar highlights
    $('#sidebar-nl-' + section2).addClass('app-active');

    //refresh
    $('#nl-refresh').click(function(e) {
        e.preventDefault();

        var url = Routing.generate('_json_refresh_inbox', {
            'inbox': 'inbox',
            'accountId': null
        });

        $('#darken').addClass('hidden').removeClass('visible');

        $.getJSON(url, function(data) {
            $('#darken').removeClass('hidden').addClass('visible');
        });
    });

    $(window).resize(function() {
        window.resizeElements();
    });

    window.resizeElements();

});
