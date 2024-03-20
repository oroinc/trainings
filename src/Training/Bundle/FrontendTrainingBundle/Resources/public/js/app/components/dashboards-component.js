import ViewComponent from 'oroui/js/app/components/view-component';
import moduleConfig from 'module-config';
const config = {
    ...moduleConfig(module.id)
};
import OrderListCollectionService from 'trainingfrontendtraining/js/app/order-list-collection-service';
import BaseCollection from 'oroui/js/app/models/base/collection';
import $ from 'jquery';

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
            config.ordersNumber
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

export default DashboardsComponent;
