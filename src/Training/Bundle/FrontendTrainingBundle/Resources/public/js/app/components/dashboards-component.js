define(function(require) {
    'use strict';

    const ViewComponent = require('oroui/js/app/components/view-component');

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
