import moduleConfig from 'module-config';
const config = {
    ...moduleConfig(module.id)
};

const timeout = (sec => {
    // Value in seconds, need to multiply by 1000 to get milliseconds
    return (sec || 10) * 1000;
})(config.datagridRefreshSec);

const handleInterval = grid => {
    if (!grid.disposed) {
        grid.refreshAction.execute();
        setTimeout(handleInterval, timeout, grid);
    }
};

export default {
    init: (deferred, options) => {
        options.gridPromise.done(grid => {
            setTimeout(handleInterval, timeout, grid);
            deferred.resolve();
        });
    }
};
