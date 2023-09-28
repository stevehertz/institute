const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file f or the application as well as bundling up all the JS files.
 | 
 */

mix.setPublicPath('public');

mix.sass('resources/sass/main.scss', 'css/')
    .sass('resources/sass/backend/app.scss', 'css/backend.css')
    .js([
        'resources/js/backend/before.js',
        'resources/js/backend/app.js',
        'resources/js/backend/after.js'
    ], 'js/backend.js')
    .extract([
        'jquery',
        'jquery-ui-dist/jquery-ui',
        'bootstrap',
        'popper.js/dist/umd/popper',
        'axios',
        'sweetalert2',
    ])
    .browserSync('127.0.0.1:8000')
    .webpackConfig(require('./webpack.config'));


if (mix.inProduction() || process.env.npm_lifecycle_event !== 'hot') {
    mix.version();
}