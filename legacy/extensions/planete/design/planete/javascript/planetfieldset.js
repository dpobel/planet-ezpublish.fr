YUI.add('planet-fieldset', function (Y) {
    Y.on('domready', function () {
        var collapsibles = Y.all('.collapsible');

        collapsibles.each(function (fieldset) {
            fieldset.one('legend').on('click', function () {
                var d = fieldset.one('.inner-collapsible'),
                    cb = function () {
                        fieldset.addClass('collapsed');
                    },
                    height = 0, h = 0, speed = 250; // px/s
                d.all('> *').each(function (elt) {
                    height += elt.get('offsetHeight')
                            + parseInt(elt.getComputedStyle('marginTop'))
                            + parseInt(elt.getComputedStyle('marginBottom'));
                });

                if ( fieldset.hasClass('collapsed') ) {
                    cb = function () {
                        fieldset.removeClass('collapsed');
                    };
                    h = height;
                }
                d.transition({
                    duration:height/speed,
                    height:h + 'px'
                }, cb);
            });
        });
    });
}, '1.0.0', ['node', 'transition']);
