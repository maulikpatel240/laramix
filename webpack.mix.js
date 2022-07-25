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
    //Bootstrap+adminlte+jquery
    .sass("resources/sass/app.scss", "public/css")
    .js("resources/assets/js/jquery.js", "public/js")
    .copyDirectory("resources/assets/js/adminlte", "public/js")
    .copyDirectory(
        "node_modules/bootstrap/dist/js/bootstrap.bundle.min.js",
        "public/js"
    )
    //extra
    // .sass("resources/sass/material-kit.scss", "public/css")
    // .sass("vendor/almasaeed2010/adminlte/src/scss/adminlte.scss", "public/css")
    .sass("resources/sass/styles.scss", "public/css")
    //overlayscrollbars
    .copy(
        "node_modules/overlayscrollbars/js/OverlayScrollbars.min.js",
        "public/plugins/overlayscrollbars/js/OverlayScrollbars.min.js"
    )
    .copy(
        "node_modules/overlayscrollbars/css/OverlayScrollbars.min.css",
        "public/plugins/overlayscrollbars/css/OverlayScrollbars.min.css"
    )
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
    //icheck-bootstrap
    .copyDirectory(
        "node_modules/icheck-bootstrap/",
        "public/plugins/icheck-bootstrap"
    )
    //sweetalert2
    .copyDirectory(
        "node_modules/sweetalert2/dist/",
        "public/plugins/sweetalert2"
    )
    //summernote
    .copyDirectory("node_modules/summernote/dist/", "public/plugins/summernote")
    //input mask
    .copyDirectory("node_modules/inputmask/dist/", "public/plugins/inputmask")
    //cloneData
    .copy("resources/assets/cloneData/cloneData.js", "public/js")
    //handlebars
    .copyDirectory("node_modules/handlebars/dist/", "public/plugins/handlebars")
    //other
    .copy("resources/assets/js/plugins/grid.js", "public/js")
    .copy("resources/assets/js/plugins/sweetalert2.js", "public/js")
    // .js("resources/assets/js/library/AdminLTE.js", "public/js")
    // .copy("resources/assets/js/library/adminlte.min.js", "public/js")
    // .copy("resources/assets/js/library/demo.js", "public/js")
    // .copy("resources/assets/js/material-kit.min.js", "public/js")
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
