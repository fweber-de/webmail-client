/**
 * Compiles a Handlebars template
 *
 * @param  string    source
 * @param  object    context
 * @return string
 */
var compileTemplate = function(source, context) {
    var template = Handlebars.compile(source);
    var html = template(context);

    return html;
};

$(document).ready(function() {

    $('.app-detail a').attr('target', '_blank');

    //element click
    $('.app-elements ul > li').click(function() {
        $('#mail-header').html('<div class="text-center"><i class="fa fa-spin fa-refresh text-success"></i></div>');

        var mailId = $(this).data('mailid');
        var url = Routing.generate('_json_get_message', {
            'id': mailId
        });

        $.getJSON(url, function(data) {
            var context = {message: data};

            //mail header
            var header = compileTemplate($("#mail-header-template").html(), context);
            $('#mail-header').html(header);

            //mail
            var mail = compileTemplate($("#mail-template").html(), context);
            $('#mail-frame').contents().find('html').html(mail);
        }).fail(function() {
            console.log('error fetching message');
        });
    });

    /**
     * HELPERS
     */

    Handlebars.registerHelper('safeString', function(str) {
        return new Handlebars.SafeString(Handlebars.escapeExpression(str));
    });

});
