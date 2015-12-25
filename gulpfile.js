var elixir = require('laravel-elixir');

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

var vendorDir = './resources/assets/vendor/';
var publicDir = './public/';
var lessPaths = [
	vendorDir + 'bootstrap/less',
	vendorDir + 'font-awesome/less',
];

elixir(function(mix) {
    mix.less('app.less')
        .less('app.vendor.less', 'public/css/app.vendor.css', { paths: lessPaths })
        .less('admin.less', 'public/css/admin.css')
        .less('admin.vendor.less', 'public/css/admin.vendor.css', { paths: lessPaths })
        .styles([
            'metisMenu/src/metisMenu.css'
        ], 'public/css/metisMenu.css', vendorDir)
    	.scripts([
    		'jquery/dist/jquery.js',
            'bootstrap/dist/js/bootstrap.js',
            'bootstrap-table/dist/bootstrap-table.js'
    	], 'public/js/app.vendor.js', vendorDir)
        .scripts([
            'app.js'
        ], 'public/js/app.js')
        .scripts([
            'jquery/dist/jquery.js',
            'bootstrap/dist/js/bootstrap.js',
            'metisMenu/src/metisMenu.js',
            'startbootstrap-sb-admin-2/dist/js/sb-admin-2.js',
            'bootstrap-table/dist/bootstrap-table.js'
        ], 'public/js/admin.vendor.js', vendorDir)
        .scripts([
            'admin.js'
        ], 'public/js/admin.js')
    	.copy(vendorDir + 'font-awesome/fonts', 'public/fonts')
    	.copy(vendorDir + 'bootstrap/fonts', 'public/fonts')
        .styles([
            publicDir + 'css/admin.vendor.css',
            publicDir + 'css/metisMenu.css',
            vendorDir + 'bootstrap-table/dist/bootstrap-table.css',
            publicDir + 'css/admin.css'
        ], 'public/css/all.admin.css')
        .styles([
            publicDir + 'css/app.vendor.css',
            vendorDir + 'bootstrap-table/dist/bootstrap-table.css',
            publicDir + 'css/app.css'
        ], 'public/css/all.app.css');
});
