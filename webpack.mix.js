let mix = require('laravel-mix');

mix.js('src/js/app.js', 'assets/js')
    .sass('src/scss/app.scss', 'assets/css')
    .setPublicPath('');