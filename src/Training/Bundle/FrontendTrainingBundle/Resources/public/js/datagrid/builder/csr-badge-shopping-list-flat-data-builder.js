import csrBadgeShoppingListRow from 'trainingfrontendtraining/js/datagrid/row/csr-badge-shopping-list-row';
import addItemsToData from 'trainingfrontendtraining/js/datagrid/processor/csr-badge-data-processor';

const csrBadgeShoppingListFlatDataBuilder = {
    processDatagridOptions(deferred, options) {
        if (options.metadata.options.parseResponseModels) {
            const previousParseResponseModelsCallback = options.metadata.options.parseResponseModels;
            Object.assign(options.metadata.options, {
                parseResponseModels: resp => {
                    // original parseResponseModels functionality is preserved, but its output is further processed by addItemsToData
                    return ('data' in resp)
                        ? addItemsToData(previousParseResponseModelsCallback(resp))
                        : previousParseResponseModelsCallback(resp);
                }
            });
        }

        options.data.data = addItemsToData(options.data.data);

        // override rowView with csrBadgeShoppingListRow including the logic to render the CSR badge
        options.themeOptions = {
            ...options.themeOptions,
            rowView: csrBadgeShoppingListRow
        };

        return deferred.resolve();
    },

    init(deferred, options) {
        return deferred.resolve();
    }
};

export default csrBadgeShoppingListFlatDataBuilder;
