const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js/scripts.js').extract([
    'axios',
    'tom-select'
]);

mix.sass('resources/css/app.scss', 'public/css/styles.css');

/**
 * Material design icons
 */
mix.copy('node_modules/boxicons/fonts', 'public/vendor/boxicons/fonts');
mix.copy('node_modules/boxicons/css', 'public/vendor/boxicons/css');