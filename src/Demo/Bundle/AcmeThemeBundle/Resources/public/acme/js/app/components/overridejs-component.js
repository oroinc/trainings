define(function(require) {
    'use strict';

    const mediator = require('oroui/js/mediator');
    const routing = require('routing');
    const $ = require('jquery');
    const __ = require('orotranslation/js/translator');
    const BaseWidgetViewComponent = require('oroshoppinglist/js/app/components/shoppinglist-widget-view-component');
    

    const ShoppingListWidgetViewComponent = BaseWidgetViewComponent.extend({
        /**
         * @inheritdoc
         */
        constructor: function ShoppingListWidgetViewComponent(options) {
            ShoppingListWidgetViewComponent.__super__.constructor.call(this, options);
        },

        /**
         * @param {Object} options
         */
        initialize: function(options) {
            ShoppingListWidgetViewComponent.__super__.initialize.call(this, options);
            console.log("overrided for example oroshoppinglist/js/app/components/shoppinglist-widget-view-component");
        }
    });

    return ShoppingListWidgetViewComponent;
});
