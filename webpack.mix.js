const mix = require("laravel-mix");
require("dotenv").config();
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js("resources/js/app.js", "public/js")
    .react()
    .sass("resources/sass/app.scss", "public/css")
    .sass("resources/sass/styles.scss", "public/css")
    .sass("resources/sass/material-kit.scss", "public/css")
    .js("resources/assets/js/jquery.js", "public/js")
    //jquery-form
    .copy("vendor/jquery-form/form/dist/jquery.form.min.js", "public/js")
    //jquery-pjax
    .copy(
        "node_modules/jquery-pjax/jquery.pjax.js",
        "public/plugins/jquery-pjax"
    )
    //dependent-dropdown
    .copyDirectory(
        "node_modules/dependent-dropdown/css/",
        "public/plugins/dependent-dropdown/css"
    )
    .copyDirectory(
        "node_modules/dependent-dropdown/js/",
        "public/plugins/dependent-dropdown/js"
    )
    .copyDirectory(
        "node_modules/dependent-dropdown/img/",
        "public/plugins/dependent-dropdown/img"
    )
    //js validation
    .copyDirectory(
        "resources/assets/jsvalidation/",
        "public/plugins/jsvalidation"
    )
    //input mask
    .copyDirectory("node_modules/inputmask/dist/", "public/plugins/inputmask")
    //cloneData
    .copy("resources/assets/cloneData/cloneData.js", "public/js")
    //other
    .copy("resources/assets/js/plugins/grid.js", "public/js")
    // .js("resources/assets/js/library/AdminLTE.js", "public/js")
    // .copy("resources/assets/js/library/adminlte.min.js", "public/js")
    // .copy("resources/assets/js/library/demo.js", "public/js")
    .copy("resources/assets/js/material-kit.min.js", "public/js")
    .copy("resources/assets/js/plugins/myfunction.js", "public/js")
    .webpackConfig({
        devServer: {
            open: true,
            host: "localhost",
        },
        // module: {
        //     rules: [
        //         {
        //             test: /\.s[ac]ss$/i,
        //             use: [stylesHandler, 'css-loader', 'postcss-loader', 'sass-loader'],
        //         },
        //         {
        //             test: /\.css$/i,
        //             use: [stylesHandler, 'css-loader', 'postcss-loader'],
        //         },
        //         {
        //             test: /\.(eot|svg|ttf|woff|woff2|png|jpg|gif)$/i,
        //             type: 'asset',
        //         },

        //         // Add your rules for custom modules here
        //         // Learn more about loaders from https://webpack.js.org/loaders/
        //     ],
        // },
    });

//mix.setPublicPath('public');
mix.setResourceRoot(process.env.APP_URL);
if (!mix.inProduction()) {
    mix.sourceMaps();
    mix.webpackConfig({ devtool: "inline-source-map" });
}
