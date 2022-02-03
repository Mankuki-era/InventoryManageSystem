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

mix.js('resources/js/app.js', 'public/js')
    .js("resources/js/router.js", "public/js")
    .vue({ version: 2 }) //追加
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/share/common.scss', 'public/css/share')
    .sass('resources/sass/user/login.scss', 'public/css/user')
    .sass('resources/sass/user/register.scss', 'public/css/user')
    .sass('resources/sass/user/show.scss', 'public/css/user')
    .sass('resources/sass/user/edit.scss', 'public/css/user')
    .sass('resources/sass/item/main.scss', 'public/css/item')
    .sass('resources/sass/item/create.scss', 'public/css/item')
    .sass('resources/sass/item/show.scss', 'public/css/item')
    .sass('resources/sass/admin/common.scss', 'public/css/admin')
    .sass('resources/sass/admin/dashboard.scss', 'public/css/admin')
    .sass('resources/sass/admin/user.scss', 'public/css/admin')
    .sass('resources/sass/admin/item.scss', 'public/css/admin')
    .sass('resources/sass/admin/cart.scss', 'public/css/admin')
    .sass('resources/sass/admin/notification.scss', 'public/css/admin')
    .sass('resources/sass/admin/thema.scss', 'public/css/admin')
    .sass('resources/sass/admin/history.scss', 'public/css/admin')
    .sass('resources/sass/cart/index.scss', 'public/css/cart')
    .sass('resources/sass/cart/confirm.scss', 'public/css/cart')
    .sourceMaps();
