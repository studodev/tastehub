const Encore = require('@symfony/webpack-encore');
const path = require("path");

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .addAliases({
        '@fonts': path.resolve(__dirname, 'assets/fonts'),
        '@images': path.resolve(__dirname, 'assets/images'),
        '@styles': path.resolve(__dirname, 'assets/scss'),
    })

    /* ----- Main entrypoint ----- */
    .addEntry('app', './assets/ts/app.ts')

    /* ----- Pages entrypoints ---- */
    .addEntry('cooking_recipe_form_common', './assets/ts/pages/cooking/recipe-form/common.ts')
    .addEntry('cooking_recipe_form_metadata', './assets/ts/pages/cooking/recipe-form/metadata.ts')
    .addEntry('cooking_recipe_form_details', './assets/ts/pages/cooking/recipe-form/details.ts')

    .addEntry('user_security_common', './assets/ts/pages/user/security/common.ts')

    .splitEntryChunks()
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = '3.23';
    })
    .enableSassLoader()
    .enableTypeScriptLoader()
    .enableIntegrityHashes(Encore.isProduction())

    .copyFiles({
        from: './assets/fonts',
        to: 'fonts/[path][name].[hash:8].[ext]',
    })
    .copyFiles({
        from: './assets/images',
        to: 'images/[path][name].[hash:8].[ext]',
    })
;

module.exports = Encore.getWebpackConfig();
