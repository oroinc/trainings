import BaseComponent from 'oroui/js/app/components/base/component';

// imported from node_modules
import 'magnific-popup';
// imported from lib folder (registered in jsmodules.yml);
import 'datatables';

/**
 * This is just an example of usage of jquery plugins.
 * In your project decide if you need to create a separate component or view.
 */
const JqueryPluginComponent = BaseComponent.extend({
    $el: null,

    constructor: function JqueryPluginComponent(options) {
        JqueryPluginComponent.__super__.constructor.call(this, options);
    },

    initialize(options) {
        this.$el = options._sourceElement;
        this.$el.find('#myImage').magnificPopup({type: 'image'});
        this.$el.find('#myTable').DataTable();
    },

    dispose: function() {
        if (this.disposed) {
            return;
        }

        JqueryPluginComponent.__super__.dispose.call(this);
    }
});

export default JqueryPluginComponent;
