const mix = require('laravel-mix');

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

const vs = 'node_modules/';

const dest = 'public/assets/';
const destFonts = dest + 'fonts/';
const destImg = dest + 'img/';
const destCss = dest + 'css/';
const destJs = dest + 'js/';
const destVendors = dest + 'vendors/';

const vendors = {
  'jquery':   vs + 'jquery/dist/',
  'sidebarjs': vs + 'sidebarjs/lib/',
  // add libraries,
};

// Sidebar JS
mix.copy(vendors.sidebarjs + 'sidebarjs.min.css', destVendors + 'sidebarjs');
mix.copy(vendors.sidebarjs + 'umd/sidebarjs.min.js', destVendors + 'sidebarjs');

mix.copy(vendors.jquery + 'jquery.min.js', destVendors + 'jquery');

// copias

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');
