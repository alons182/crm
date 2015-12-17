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

elixir(function(mix) {
    mix.sass('app.scss')

    .scripts([
            //'jquery-1.11.1.min.js',
            /*'jquery.magnific-popup.min.js',*/
            'handlebars-v3.0.3.js',
            'ajaxupload.js',
            'admin.js'
        ],'public/js/bundle.js','resources/assets/js')

        .version([
            
            'public/js/bundle.js',
         
        ]);
});
