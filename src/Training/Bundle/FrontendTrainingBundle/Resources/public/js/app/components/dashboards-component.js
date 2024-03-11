define(function(require, exports, module) {
    'use strict';

    const moduleConfig = require('module-config').default(module.id);
    const ViewComponent = require('oroui/js/app/components/view-component');
    const OrderListCollectionService = require('trainingfrontendtraining/js/app/order-list-collection-service');
    const BaseCollection = require('oroui/js/app/models/base/collection');
    const $ = require('jquery');

    const DashboardsComponent = ViewComponent.extend({
        /**
         * @inheritdoc
         */
        constructor: function DashboardsComponent(options) {
            DashboardsComponent.__super__.constructor.call(this, options);
        },

        /**
         * @inheritdoc
         */
        initialize: function(options) {
            DashboardsComponent.__super__.initialize.call(this, options);

            $.ajax({
                url: this.getUrl(),
                type: 'GET',
                success: function(orders) {
                    OrderListCollectionService.orderListCollection.resolve(new BaseCollection(orders));
                }
            });
        },

        getUrl: function() {
            return [
                '/api/orders',
                '?page=1',
                '&limit=',
                moduleConfig.ordersNumber
            ].join('');
        },

        /**
         * @inheritdoc
         */
        dispose: function() {
            if (this.disposed) {
                return;
            }

            DashboardsComponent.__super__.dispose.call(this);
        }
    });

    return DashboardsComponent;
});
