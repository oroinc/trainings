import _ from 'underscore';

const csrBadgeModel = item => {
    return {
        id: 'csr-badge-' + _.uniqueId(),
        isCsrBadge: true,
        originalItem: item
    };
};

export const addItemsToData = data => {
    return data.reduce((flatData, item) => {
        if (item._isVariant) {
            flatData.push(item);

            return flatData;
        }

        flatData.push(item);

        // Add CSR badge for out of stock items
        if (item.inventoryStatus === 'out_of_stock' && !isNaN(Number(item.id))) { // Avoid duplicate badge for existing notification item
            flatData.push(csrBadgeModel(item));
        }

        return flatData;
    }, []);
};

export default addItemsToData;
