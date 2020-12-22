let mix = require('laravel-mix');
require('laravel-mix-tailwind');

mix.js('src/js/app.js', 'assets/js')
    .sass('src/scss/app.scss', 'assets/css')
    .tailwind();