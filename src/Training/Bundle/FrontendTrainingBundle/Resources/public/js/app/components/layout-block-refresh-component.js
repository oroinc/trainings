import BaseComponent from 'oroui/js/app/components/base/component';
import moduleConfig from 'module-config';
import LayoutSubtreeView from 'oroui/js/app/views/layout-subtree-view';
import mediator from 'oroui/js/mediator';

const config = {
    ...moduleConfig(module.id)
};

const LayoutBlockRefreshComponent = BaseComponent.extend({
    $el: null,

    /** @property {null|number} */
    intervalId: null,

    constructor: function LayoutBlockRefreshComponent(options) {
        LayoutBlockRefreshComponent.__super__.constructor.call(this, options);
    },

    initialize(options) {
        this.$el = options._sourceElement;

        // if there is no config.datagridRefreshSec set, do not initialize this component
        if (!config.datagridRefreshSec) {
            return;
        }

        // check if options.refreshBlockId and options.reloadEvents are set, if not, throw error
        if (!options.refreshBlockId || !options.reloadEvents) {
            throw new Error('refreshBlockId and reloadEvents are required options in layout-block-refresh-component');
        }

        new LayoutSubtreeView({
            el: this.$el,
            blockId: options.refreshBlockId,
            reloadEvents: options.reloadEvents,
            restoreFormState: true
        });

        // call mediator trigger to refresh the block every x seconds (from config)
        this.intervalId = setInterval(() => {
            mediator.trigger('training-product-datagrid:refresh');
        }, config.datagridRefreshSec * 1000);
    },

    dispose: function() {
        if (this.disposed) {
            return;
        }

        if (this.intervalId) {
            clearInterval(this.intervalId);
        }

        LayoutBlockRefreshComponent.__super__.dispose.call(this);
    }
});

export default LayoutBlockRefreshComponent;
