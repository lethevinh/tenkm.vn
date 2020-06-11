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
let deleteFolderRecursive = function (path) {
    if (fs.existsSync(path)) {
        fs.readdirSync(path).forEach(function (file, index) {
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
            new WebpackShellPlugin({onBuildStart: ['php artisan lang:js'], onBuildEnd: []})
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
// theme
let theme = 'realdeal';

mix.styles([
    'resources/themes/realdeal/css/vendor.css',
    'resources/themes/realdeal/css/style.css',
    'resources/themes/realdeal/css/responsive.css',
    'resources/themes/realdeal/css/custom.css'
], 'public/css/theme.css');

mix.copy('resources/themes/realdeal/js/vendor.js', 'public/js/vendor.js')
    .copy('resources/themes/realdeal/js/theme.js', 'public/js/theme.js')
    .copyDirectory('resources/themes/realdeal/img', 'public/images')
    .copyDirectory('resources/themes/realdeal/fonts', 'public/fonts')
    .autoload({
        jquery: ['$', 'window.jQuery', 'jQuery']
    })
    .version();
