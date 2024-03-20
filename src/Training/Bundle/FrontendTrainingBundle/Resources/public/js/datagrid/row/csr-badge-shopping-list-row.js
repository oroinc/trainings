import ShoppingListRow from 'oroshoppinglist/js/datagrid/row/shopping-list-row';
import csrBadgeRowTemplate from 'tpl-loader!trainingfrontendtraining/templates/datagrid/row/csr-badge-row.html';

const CsrBadgeShoppingListRow = ShoppingListRow.extend({
    constructor: function ShoppingListProductGroupRow(options) {
        ShoppingListProductGroupRow.__super__.constructor.call(this, options);
    },

    renderAllItems: function() {
        if (this.model.get('isCsrBadge')) {
            this.renderCsrBadge();
            return;
        }

        return CsrBadgeShoppingListRow.__super__.renderAllItems.call(this);
    },

    renderCsrBadge: function() {
        this.$el.html(csrBadgeRowTemplate({
            columnsCount: this.columns.filter(column => column.get('renderable')).length
        }));

        this.$el.removeClass('has-actions has-select-action').addClass('has-badge');
    }
});

export default CsrBadgeShoppingListRow;
