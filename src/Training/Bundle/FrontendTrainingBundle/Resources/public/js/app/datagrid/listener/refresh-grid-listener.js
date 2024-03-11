define(['module-config', 'module'], function(moduleConfig, module) {
    'use strict';

    const timeout = (sec => {
        // Value in seconds, need to multiply by 1000 to get milliseconds
        return (sec || 10) * 1000;
    })(moduleConfig.default(module.id).datagridRefreshSec);

    function handleInterval(grid) {
        if (!grid.disposed) {
            grid.refreshAction.execute();
            setTimeout(handleInterval, timeout, grid);
        }
    }

    return {
        init: (deferred, options) => {
            options.gridPromise.done(grid => {
                setTimeout(handleInterval, timeout, grid);
                deferred.resolve();
            });
        }
    };
});
