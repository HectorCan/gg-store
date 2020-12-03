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

mix//.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');

mix.copy('node_modules/@coreui/chartjs/dist/css/coreui-chartjs.css', 'public/css');
mix.copy('node_modules/cropperjs/dist/cropper.css', 'public/css');
//main css
mix.sass('resources/sass/style.scss', 'public/css');

//************** SCRIPTS ******************
// general scripts
mix.copy('node_modules/@coreui/utils/dist/coreui-utils.js', 'public/js');
mix.copy('node_modules/axios/dist/axios.min.js', 'public/js');
//mix.copy('node_modules/pace-progress/pace.min.js', 'public/js');
mix.copy('node_modules/@coreui/coreui/dist/js/coreui.bundle.min.js', 'public/js');
// views scripts
mix.copy('node_modules/chart.js/dist/Chart.min.js', 'public/js');
mix.copy('node_modules/@coreui/chartjs/dist/js/coreui-chartjs.bundle.js', 'public/js');

mix.copy('node_modules/cropperjs/dist/cropper.js', 'public/js');
// details scripts
mix.copy('resources/js/coreui/main.js', 'public/js');
mix.copy('resources/js/coreui/colors.js', 'public/js');
mix.copy('resources/js/coreui/charts.js', 'public/js');
mix.copy('resources/js/coreui/widgets.js', 'public/js');
mix.copy('resources/js/coreui/popovers.js', 'public/js');
mix.copy('resources/js/coreui/tooltips.js', 'public/js');
// details scripts admin-panel
mix.js('resources/js/coreui/menu-create.js', 'public/js');
mix.js('resources/js/coreui/menu-edit.js', 'public/js');
mix.js('resources/js/coreui/media.js', 'public/js');
mix.js('resources/js/coreui/media-cropp.js', 'public/js');
//*************** OTHER ******************
//fonts
mix.copy('node_modules/@coreui/icons/fonts', 'public/fonts');
//icons
mix.copy('node_modules/@coreui/icons/css/free.min.css', 'public/css');
mix.copy('node_modules/@coreui/icons/css/brand.min.css', 'public/css');
mix.copy('node_modules/@coreui/icons/css/flag.min.css', 'public/css');
mix.copy('node_modules/@coreui/icons/svg/flag', 'public/svg/flag');

mix.copy('node_modules/@coreui/icons/sprites/', 'public/icons/sprites');

mix.copy('node_modules/datatables.net/js/', destVendors + 'datatables.net/js/');
mix.copy('node_modules/datatables.net-dt/css/', destVendors + 'datatables.net/css/');
mix.copy('node_modules/datatables.net-dt/images/', destVendors + 'datatables.net/images/');

mix.copy('node_modules/jquery-form/dist/', destVendors + 'jquery-form/js/')
//images
mix.copy('resources/assets', 'public/assets');
