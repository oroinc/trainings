const OroConfig = require('@oroinc/oro-webpack-config-builder');

OroConfig
    .enableLayoutThemes()
    .setPublicPath('public/')
    .setCachePath('var/cache')
    .setBabelConfig({
        ...OroConfig._babelConfig,
        'presets': [...OroConfig._babelConfig.presets, '@babel/preset-react']
    });

module.exports = OroConfig.getWebpackConfig();
