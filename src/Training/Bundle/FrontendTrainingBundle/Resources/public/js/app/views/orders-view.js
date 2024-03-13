define(function(require) {
    'use strict';

    const BaseView = require('oroui/js/app/views/base/view');
    const OrderListCollectionService = require('trainingfrontendtraining/js/app/order-list-collection-service');
    const template = require('tpl-loader!trainingfrontendtraining/templates/orders-template.html');
    const dateTimeFormatter = require('orolocale/js/formatter/datetime');
    const NumberFormatter = require('orolocale/js/formatter/number');
    const LoadingMaskView = require('oroui/js/app/views/loading-mask-view');

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

            this.subview('loading', new LoadingMaskView({
                container: this.$el
            }));
            this.subview('loading').show();

            OrderListCollectionService.orderListCollection.done(function(orderListCollection) {
                this.orderListCollection = orderListCollection;
                this.subview('loading').hide();
                this.render();
            }.bind(this));
        },

        render: function() {
            this.$el.html(template({
                orders: this.orderListCollection.toJSON(),
                formatDate: function(dateString) {
                    const dateTime = new Date();
                    dateTime.setTime(Date.parse(dateString));
                    return dateTimeFormatter.formatDateTime(dateTime);
                },
                formatCurrency: function(price, currency) {
                    return NumberFormatter.formatCurrency(price, currency);
                }
            }));
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
