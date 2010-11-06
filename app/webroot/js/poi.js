/**
 * pois
 *
 * for PoisController
 */
var Poi = {};

/**
 * functions to execute when document is ready
 *
 * only for PoisController
 *
 * @return void
 */
Poi.documentReady = function() {
    Poi.addAction();
    Poi.removeAction();
	Poi.borraFoto();
}

/**
 * add meta field
 *
 * @return void
 */
Poi.addAction = function() {
    $('a.add-action').click(function() {
        $.get(Layar.basePath+'poi/add_action/', function(data) {
            $('#acciones-fields div.clear').before(data);
            $('div.meta a.remove-action').unbind();
            Poi.removeAction();
        });
        return false;
    });
}

/**
 * remove meta field
 *
 * @return void
 */
Poi.removeAction = function() {
    $('div.meta a.remove-action').click(function() {
        var aRemoveAction = $(this);
        if (aRemoveAction.attr('rel') != '') {
            $.getJSON(Layar.basePath+'poi/delete_action/'+$(this).attr('rel')+'.json', function(data) {
                if (data.success) {
                    aRemoveAction.parents('.meta').remove();
                } else {
                    trace("error");
                }
            });
        } else {
            aRemoveAction.parents('.meta').remove();
        }
        return false;
    });
}

/**
 * borra foto
 *
 * @return void
 */
Poi.borraFoto = function() {
    $('div.borrafoto a.borra').click(function() {
        var aBorraFoto = $(this);
        if (aBorraFoto.attr('rel') != '') {
            $.getJSON(Layar.basePath+'poi/borra_foto/'+$(this).attr('rel')+'.json', function(data) {
                if (data.success) {
                    aBorraFoto.parents('.borrafoto').remove();
                } else {
                    trace("error");
                }
            });
        } else {
            aBorraFoto.parents('.borrafoto').remove();
        }
        return false;
    });
}

/**
 * document ready
 *
 * @return void
 */
$(document).ready(function() {
        Poi.documentReady();
});