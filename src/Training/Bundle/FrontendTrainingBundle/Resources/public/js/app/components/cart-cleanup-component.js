import BaseComponent from 'oroui/js/app/components/base/component';
import routing from 'routing';
import $ from 'jquery';
import messenger from 'oroui/js/messenger';
import __ from 'orotranslation/js/translator';
import mediator from 'oroui/js/mediator';

const CartCleanupComponent = BaseComponent.extend({
    options: {
        route: null,
        shoppingListId: null
    },

    /**
     * @inheritDoc
     */
    constructor: function CartCleanupComponent(options) {
        CartCleanupComponent.__super__.constructor.call(this, options);
    },

    /**
     * @inheritDoc
     */
    initialize: function(options) {
        this.options.route = options.route || null;
        this.options.shoppingListId = options.shoppingListId || null;
        this.$el = options._sourceElement;
        CartCleanupComponent.__super__.initialize.call(this, options);

        this.$el.on('click.' + this.cid, this.cleanupCart.bind(this));
    },

    cleanupCart: function(ev) {
        ev.preventDefault();

        $.ajax({
            method: 'POST',
            url: routing.generate(this.options.route, {
                id: this.options.shoppingListId
            }),
            success: response => {
                messenger.notificationMessage(
                    'success',
                    __('training.frontend_training.cart_cleanup.success')
                );

                mediator.trigger('shopping-list:refresh');
                mediator.trigger('datagrid:doRefresh:frontend-customer-user-shopping-list-edit-grid');
            },
            error: error => {
                messenger.notificationMessage(
                    'error',
                    __('training.frontend_training.cart_cleanup.error')
                );
            }
        });
    },

    /**
     * @inheritDoc
     */
    dispose: function() {
        if (this.disposed) {
            return;
        }

        this.$el.off('.' + this.cid);

        CartCleanupComponent.__super__.dispose.call(this);
    }
});

export default CartCleanupComponent;
