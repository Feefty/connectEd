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
			'tableExport.jquery.plugin/tableExport.js',
			'tableExport.jquery.plugin/jquery.base64.js',
			'tableExport.jquery.plugin/html2canvas.js',
			'tableExport.jquery.plugin/jspdf/libs/sprintf.js',
			'tableExport.jquery.plugin/jspdf/jspdf.js',
			'tableExport.jquery.plugin/jspdf/libs/base64.js',
            'bootstrap-table/dist/bootstrap-table.js',
            'bootstrap-select/dist/js/bootstrap-select.min.js',
            'jquery-timeago/jquery.timeago.js',
            'bootstrap-table/dist/extensions/filter/bootstrap-table-filter.js',
			'bootstrap-table-filter/src/bootstrap-table-filter.js',
            'bootstrap-table/dist/extensions/export/bootstrap-table-export.js',
            'bootstrap-table/dist/extensions/multiple-search/bootstrap-table-multiple-search.js',
            'Chart.js/Chart.min.js',
			'summernote/dist/summernote.min.js',
			'moment/min/moment.min.js',
			'fullcalendar/dist/fullcalendar.min.js'
    	], 'public/js/app.vendor.js', vendorDir)
        .scripts([
            'app.js',
            publicDir + 'js/jasny-bootstrap.min.js'
        ], 'public/js/app.js')
        .scripts([
            'jquery/dist/jquery.js',
            'bootstrap/dist/js/bootstrap.js',
            'metisMenu/src/metisMenu.js',
            'startbootstrap-sb-admin-2/dist/js/sb-admin-2.js',
			'tableExport.jquery.plugin/tableExport.js',
			'tableExport.jquery.plugin/jquery.base64.js',
			'tableExport.jquery.plugin/html2canvas.js',
			'tableExport.jquery.plugin/jspdf/libs/sprintf.js',
			'tableExport.jquery.plugin/jspdf/jspdf.js',
			'tableExport.jquery.plugin/jspdf/libs/base64.js',
            'bootstrap-table/dist/bootstrap-table.js',
            'bootstrap-table/dist/extensions/filter/bootstrap-table-filter.js',
			'bootstrap-table-filter/src/bootstrap-table-filter.js',
            'bootstrap-table/dist/extensions/export/bootstrap-table-export.js',
            'bootstrap-table/dist/extensions/multiple-search/bootstrap-table-multiple-search.js',
            'bootstrap-select/dist/js/bootstrap-select.min.js',
            'Chart.js/Chart.min.js',
			'jquery-minicolors/jquery.minicolors.min.js',
			'summernote/dist/summernote.min.js',
			'moment/min/moment.min.js',
			'fullcalendar/dist/fullcalendar.min.js'
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
            vendorDir + 'jquery-minicolors/jquery.minicolors.css',
            vendorDir + 'bootstrap-select/dist/css/bootstrap-select.min.css',
			vendorDir + 'bootstrap-table-filter/src/bootstrap-table-filter.css',
			vendorDir + 'summernote/dist/summernote.css',
			vendorDir + 'fullcalendar/dist/fullcalendar.min.css',
            publicDir + 'css/admin.css',
        ], 'public/css/all.admin.css')
        .styles([
            publicDir + 'css/app.vendor.css',
            vendorDir + 'bootstrap-table/dist/bootstrap-table.css',
            vendorDir + 'bootstrap-select/dist/css/bootstrap-select.min.css',
            publicDir + 'css/jasny-bootstrap.min.css',
			vendorDir + 'bootstrap-table-filter/src/bootstrap-table-filter.css',
			vendorDir + 'summernote/dist/summernote.css',
			vendorDir + 'fullcalendar/dist/fullcalendar.min.css',
            publicDir + 'css/app.css'
        ], 'public/css/all.app.css');
});
