define(function(require) {
    'use strict';

    var ShowHideComponent;
    var _ = require('underscore');
    var BaseComponent = require('oroui/js/app/components/base/component');

    ShowHideComponent = BaseComponent.extend({
        /**
         * @property {Object}
         */
        element: null,

        /**
         * @property {string}
         */
        triggerClass: 'default-sh-trigger',

        /**
         * @property {Object}
         */
        triggerElement: null,

        /**
         * @property {string}
         */
        blockClass: 'default-sh-block',

        /**
         * @property {Object}
         */
        blockElement: null,

        /**
         * @inheritDoc
         */
        initialize: function(options) {
            this.element = options._sourceElement;
            if (!this.element) {
                return;
            }

            if (options.triggerClass) {
                this.triggerClass = options.triggerClass;
            }
            this.triggerElement = this.element.find('.' + this.triggerClass).first();

            if (options.blockClass) {
                this.blockClass = options.blockClass;
            }
            this.blockElement = this.element.find('.' + this.blockClass).first();

            if (this.triggerElement.length && this.blockElement.length) {
                this.triggerElement.on('click.' + this.cid, _.bind(this.showOrHideBlock, this));
            }
        },

        showOrHideBlock: function() {
            if (this.blockElement.hasClass('hide')) {
                this.blockElement.removeClass('hide');
            } else {
                this.blockElement.addClass('hide');
            }
        },

        /**
         * @inheritDoc
         */
        dispose: function() {
            if (this.disposed || !this.element) {
                return;
            }

            if (this.triggerElement.length && this.blockElement.length) {
                this.triggerElement.off('.' + this.cid);
            }

            ShowHideComponent.__super__.dispose.call(this);
        }
    });

    return ShowHideComponent;
});
