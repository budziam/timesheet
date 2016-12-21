const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(mix => {
    mix.sass('app/core.scss', 'public/css/app.css')
        .webpack('app/core.js', 'public/js/app.js');

    mix.sass('dashboard/core.scss', 'public/css/dashboard.css')
        .webpack('dashboard/core.js', 'public/js/dashboard.js');
});
