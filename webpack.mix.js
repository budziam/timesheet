let mix = require('laravel-mix');

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

mix
    .js('resources/assets/js/app/core.js', 'public/js/app.js')
    .sass('resources/assets/sass/app/core.scss', 'public/css/app.css')
    .js('resources/assets/js/dashboard/core.js', 'public/js/dashboard.js')
    .sass('resources/assets/sass/dashboard/core.scss', 'public/css/dashboard.css');

if (mix.inProduction()) {
    mix.version();
}
