import shoppingListFlatDataBuilder from 'oroshoppinglist/js/datagrid/builder/shoppinglist-flat-data-builder';
import csrBadgeShoppingListRow from 'trainingfrontendtraining/js/datagrid/row/csr-badge-shopping-list-row';
import addItemsToData from 'trainingfrontendtraining/js/datagrid/processor/csr-badge-data-processor';
import $ from 'jquery';
import _ from 'underscore';

const csrBadgeShoppingListFlatDataBuilder = _.extend({}, shoppingListFlatDataBuilder, {
    processDatagridOptions(deferred, options) {
        const newDeferred = $.Deferred();
        newDeferred.promise().done(() => {
            if (options.metadata.options.parseResponseModels) {
                const previousParseResponseModelsCallback = options.metadata.options.parseResponseModels;
                Object.assign(options.metadata.options, {
                    parseResponseModels: resp => {
                        return ('data' in resp)
                            ? addItemsToData(previousParseResponseModelsCallback(resp))
                            : previousParseResponseModelsCallback(resp);
                    }
                });
            }

            options.data.data = addItemsToData(options.data.data);

            options.themeOptions = {
                ...options.themeOptions,
                rowView: csrBadgeShoppingListRow
            };

            deferred.resolve();
        });

        shoppingListFlatDataBuilder.processDatagridOptions(newDeferred, options);

        return deferred;
    }
});

export default csrBadgeShoppingListFlatDataBuilder;
