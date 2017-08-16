const {mix} = require('laravel-mix');
var exec    = require('child_process').exec;

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


mix.less('resources/assets/less/bootstrap/bootstrap.less', '../resources/assets/css')
	.less('resources/assets/less/admin.less', '../resources/assets/css')
	.less('resources/assets/less/client.less', '../resources/assets/css');

mix.combine([
	'resources/assets/css/bootstrap.css',
	'resources/assets/css/admin.css',
	'resources/assets/css/font-awesome.css'
], 'public/css/admin.css');

mix.combine([
	'resources/assets/css/bootstrap.css',
	'resources/assets/css/client.css',
	'resources/assets/css/jquery-ui.min.css',
	'resources/assets/css/font-awesome.css'
], 'public/css/client.css');

exec('php artisan js:translate', function (err, stdout, stderr) {
	console.log(stdout);
	if (stderr != '') {
		console.log('errors: ', stderr);
	}
});

mix.combine([
	'resources/assets/js/jquery-ui.min.js',
	'resources/assets/js/app.js',
	'resources/assets/js/trans.js'
], 'public/js/app.js');

if (mix.config.inProduction) {
	mix.version();
}