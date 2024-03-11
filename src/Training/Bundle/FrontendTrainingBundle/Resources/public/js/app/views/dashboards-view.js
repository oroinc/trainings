define(function(require) {
    'use strict';

    const BaseView = require('oroui/js/app/views/base/view');
    const UserStatsSubview = require('trainingfrontendtraining/js/app/views/users-stats-view');
    const OrdersView = require('trainingfrontendtraining/js/app/views/orders-view');
    const _ = require('underscore');

    const DashboardView = BaseView.extend({

        options: {},

        /**
         * @inheritdoc
         */
        constructor: function DashboardView(options) {
            DashboardView.__super__.constructor.call(this, options);
        },

        /**
         * @inheritdoc
         */
        initialize: function(options) {
            DashboardView.__super__.initialize.call(this, options);

            this.options = _.defaults(options || {}, this.options);
            options.usersOptions && this.subview('users', new UserStatsSubview(_.extend(options.usersOptions, {
                el: this.$el.find(options.usersOptions._sourceElement)[0],
                autoRender: true
            })));

            options.ordersOptions && this.subview('orders', new OrdersView({
                el: this.$el.find(options.ordersOptions._sourceElement)[0]
            }));
        },

        /**
         * @inheritdoc
         */
        dispose: function() {
            if (this.disposed) {
                return;
            }

            return DashboardView.__super__.dispose.call(this);
        }
    });

    return DashboardView;
});
