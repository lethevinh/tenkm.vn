const mix = require('laravel-mix');
const WebpackShellPlugin = require('webpack-shell-plugin');
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
const fs = require('fs');
let deleteFolderRecursive = function(path) {
    if (fs.existsSync(path)) {
        fs.readdirSync(path).forEach(function(file, index) {
            var curPath = path + "/" + file;
            if (fs.lstatSync(curPath).isDirectory()) { // recurse
                deleteFolderRecursive(curPath);
            } else { // delete file
                fs.unlinkSync(curPath);
            }
        });
        fs.rmdirSync(path);
    }
};

deleteFolderRecursive('./public/css');
deleteFolderRecursive('./public/js');

mix.webpackConfig({
    plugins:
        [
            new WebpackShellPlugin({onBuildStart:['php artisan lang:js'], onBuildEnd:[]})
        ]
});

// mix.setPublicPath('dist');
//---- admin-----
mix.sass('resources/sass/admin/app.scss', 'public/css/vi-admin.css');
mix.sass('resources/sass/admin/skin-vi-admin.scss', 'public/css/skin-vi-admin.css');

mix.styles([
    'resources/css/admin/app.css'
], 'public/css/bundle-admin.css');
mix.js([
    'resources/js/admin/app.js',
], 'public/js/').extract(['jquery', 'hotkeys-js'], 'js/bundle-admin');

mix.copy('resources/js/admin/app.js', 'public/js/vi-admin.js');
mix.copy('node_modules/hotkeys-js/dist/hotkeys.min.js', 'public/plugins/hotkeys.min.js');
mix.copy('vendor/ckfinder/ckfinder-laravel-package/public/ckfinder', 'public/plugins/ckfinder');
mix.copy('vendor/ckfinder/ckfinder-laravel-package/public/ckfinder', 'public/js/ckfinder');
mix.copy('node_modules/icheck/', 'public/plugins/icheck');
//----end admin------
// videojs
mix.js([
    'resources/themes/default/js/edureal.js',
    'resources/themes/default/js/user.js',
    'resources/themes/default/assets/js/theme.js',
], 'public/js/')
    .extract(['jquery', 'bootstrap', 'jquery-countdown','toastr', 'aos', 'owl.carousel','sweetalert2', 'jquery-countto', 'lightbox2', 'axios'], 'js/vendor');

mix.styles([
    'node_modules/font-awesome/css/font-awesome.min.css',
    'node_modules/@housfy/x-editable/dist/bootstrap3-editable/css/bootstrap-editable.css',
    'node_modules/bootstrap/dist/css/bootstrap.css',
    'node_modules/video.js/dist/video-js.min.css',
    'node_modules/toastr/build/toastr.min.css',
    'node_modules/sweetalert2/dist/sweetalert2.min.css',
    'node_modules/videojs-playlist-ui/dist/videojs-playlist-ui.css',
    'resources/themes/default/assets/css/edureal-skin-player.css',
    'resources/themes/default/assets/css/theme.css',
    'resources/themes/default/assets/css/custom.css'
], 'public/css/edureal.css');

mix.js([
    'resources/themes/default/js/app.js'
], 'public/js/app.js')
    // .copy('resources/themes/default/assets/css/theme.css', 'public/css/theme.css')
    // .copy('resources/themes/default/assets/css/custom.css', 'public/css/custom.css')
    .copy('resources/themes/default/assets/plugins/lightbox/dist/css/lightbox.css', 'public/css/lightbox.css')
    .copy('resources/themes/default/assets/plugins/ionicons/css/ionicons.min.css', 'public/css/ionicons.min.css')
    .copy('resources/themes/default/assets/plugins/owl-carousel/dist/assets/owl.carousel.min.css', 'public/css/owl.carousel.min.css')
    .copy('resources/themes/default/assets/plugins/owl-carousel/dist/assets/owl.theme.default.min.css', 'public/css/owl.theme.default.min.css')
    .copy('resources/themes/default/assets/plugins/aos-master/dist/aos.css', 'public/css/aos.css')

    .copy('resources/themes/default/assets/js/theme.js', 'public/js/theme.js')
    .copy('resources/themes/default/assets/js/google_maps.js', 'public/js/google_maps.js')
    .copyDirectory('resources/themes/default/assets/plugins', 'public/plugins')
    .copyDirectory('resources/themes/default/assets/bootstrap', 'public/plugins/bootstrap')
    .copyDirectory('resources/themes/default/assets/js', 'public/js')
    // .copyDirectory('resources/themes/default/assets/css', 'public/css')
    .copyDirectory('resources/themes/default/assets/docs', 'public/docs')
    .copyDirectory('node_modules/font-awesome/fonts', 'public/fonts')
    .copyDirectory('node_modules/@housfy/x-editable/test/libs/bootstrap300/fonts', 'public/fonts')
    .copyDirectory('node_modules/@housfy/x-editable/dist/bootstrap3-editable/img', 'public/img')
    .copyDirectory('resources/themes/default/assets/img', 'public/assets/img')
    .copyDirectory('resources/themes/default/assets/img', 'public/img')
    .copyDirectory('resources/themes/default/assets/plugins/lightbox/dist/images', 'public/images')
    .copyDirectory('resources/themes/default/assets/video', 'public/assets/video')
    .copyDirectory('resources/themes/default/assets/ico', 'public/assets/ico')
    .copyDirectory('resources/themes/default/assets/plugins/ionicons/fonts', 'public/fonts')

    .autoload({
        jquery: ['$', 'window.jQuery', 'jQuery']
    })
    .version();
