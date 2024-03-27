import BaseProductView from 'oroproduct/js/app/views/base-product-view';
import messenger from 'oroui/js/messenger';
import $ from 'jquery';
import __ from 'orotranslation/js/translator';

const CustomProductView = BaseProductView.extend({
    options: {
        copySelector: '.cms-typography'
    },

    /**
     * @inheritdoc
     */
    constructor: function CustomProductView(options) {
        CustomProductView.__super__.constructor.call(this, options);
    },

    /**
     * @inheritdoc
     */
    initialize: function(options) {
        this.options.copySelector = options.copySelector || this.options.copySelector;
        CustomProductView.__super__.initialize.call(this, options);
        this.$el = $(options.el);

        this.$el.on('click', this.options.copySelector, this.onCopyClick.bind(this));
    },

    onCopyClick: function(e) {
        e.preventDefault();

        const $target = $(e.target);

        try {
            $target.select(); // will focus on first paragraph
            navigator.clipboard.writeText($target.text()).then(() => {
                messenger.notificationMessage(
                    'success',
                    __('training.frontend_training.product_view.copy_to_clipboard.success')
                );
            }).catch(() => {
                messenger.notificationMessage(
                    'error',
                    __('training.frontend_training.product_view.copy_to_clipboard.error')
                );
            });
        } catch (err) {
            messenger.notificationMessage(
                'error',
                __('training.frontend_training.product_view.copy_to_clipboard.error')
            );
        }
    },

    dispose: function() {
        if (this.disposed) {
            return;
        }

        this.$el.off('click', this.options.copySelector, this.onCopyClick);

        CustomProductView.__super__.dispose.call(this);
    }
});

export default CustomProductView;
