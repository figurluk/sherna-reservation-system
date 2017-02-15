const {mix} = require('laravel-mix');

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

mix.js('resources/assets/js/app.js', 'public/js');
mix.js('resources/assets/gentellela/custom.js', 'public/js');

mix.less('resources/assets/less/bootstrap/bootstrap.less','../resources/assets/css')
	.less('resources/assets/less/app.less','../resources/assets/css');

mix.combine([
	'resources/assets/css/bootstrap.css',
	'resources/assets/gentellela/custom.css',
	'resources/assets/css/app.css',
	'resources/assets/css/font-awesome.css',
], 'public/css/all.css');

if (mix.config.inProduction) {
	mix.version();
}