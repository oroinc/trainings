define(function(require) {
    'use strict';

    const BaseView = require('oroorder/js/app/views/shipping-cost-view');

    const ShippingCostView = BaseView.extend({

        constructor: function ShippingCostView(options) {
            ShippingCostView.__super__.constructor.call(this, options);
        },

        initialize: function(options) {
            ShippingCostView.__super__.initialize.call(this, options);
            // pass custom initialize logic
            console.log(this);
        }
    });

    return ShippingCostView;
});
