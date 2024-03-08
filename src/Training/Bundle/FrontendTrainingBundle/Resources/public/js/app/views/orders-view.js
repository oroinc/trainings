define(function(require) {
    'use strict';

    const BaseView = require('oroui/js/app/views/base/view');
    const OrderListCollectionService = require('trainingfrontendtraining/js/app/order-list-collection-service');

    const OrdersView = BaseView.extend({

        /** @property {Object} */
        orderListCollection: null,

        /**
         * @inheritdoc
         */
        constructor: function OrdersView(options) {
            OrdersView.__super__.constructor.call(this, options);
        },

        /**
         * @inheritdoc
         */
        initialize: function(options) {
            OrdersView.__super__.initialize.call(this, options);

            // Use the new service
            OrderListCollectionService.orderListCollection.done(function(orderListCollection) {
                this.orderListCollection = orderListCollection;
                this.render();
            });
        },

        render: function() {

        },

        /**
         * @inheritdoc
         */
        dispose: function() {
            if (this.disposed) {
                return;
            }
            this.userStats = [];

            return OrdersView.__super__.dispose.call(this);
        }
    });

    return OrdersView;
});
