var elixir = require('laravel-elixir');

elixir(function(mix) {
    mix
        //.phpUnit()
        //
        //// Copy webfont files from /vendor directories to /public directory.
        .copy('./resources/assets/js/font-awesome/fonts', 'public/build/fonts')
        .copy('vendor/twbs/bootstrap-sass/assets/fonts/bootstrap', 'public/build/fonts')
        .copy('vendor/twbs/bootstrap/dist/js/bootstrap.min.js', 'public/js/vendor')
        .copy('./resources/assets/js/Ionicons/fonts', 'public/build/fonts')


        .styles([  // Combine pre-processed CSS files
                './resources/assets/js/bootstrap/dist/css/bootstrap.min.css',
                './resources/assets/js/bootstrap/dist/css/bootstrap-theme.min.css',
                './resources/assets/js/font-awesome/css/font-awesome.css',
                'frontend/style.css'
            ], 'public/css/frontend.css');
});

