define(function(require) {
    'use strict';

    const $ = require('jquery');
    const _ = require('underscore');
    const BaseView = require('oroui/js/app/views/base/view');

    const NewJsView = BaseView.extend({

               /**
         * @inheritDoc
         */
        constructor: function NewJsView() {
            NewJsView.__super__.constructor.apply(this, arguments);
            console.log("New js is added for example");
        },

        dispose: function() {
            NewJsView.__super__.dispose.call(this);
        }
    });

    return NewJsView;
});
