define(function(require, exports, module) {
    'use strict';

    const regexConstraint = require('oroform/js/validator/regex');
    const __ = require('orotranslation/js/translator');
    const config = require('module-config').default(module.id);

    return [
        'Training\\Bundle\\FrontendTrainingBundle\\Validator\\Constraints\\AllowedEmailDomain',
        function(value, element, param) {
            if (config.allowedEmailDomain === null) {
                return true;
            }
            // create a regex pattern which will check that the following email is from the allowed domain
            param.pattern = '/^([a-zA-Z0-9._%-]+)@' + String(config.allowedEmailDomain) + '$/';
            return regexConstraint[1].call(this, value, element, param);
        },
        function(param) {
            const placeholders = {};
            placeholders.allowed_email_domain = config.allowedEmailDomain;

            return __(param.message, placeholders);
        }
    ];
});
