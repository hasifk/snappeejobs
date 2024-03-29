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
                './resources/assets/js/owl.carousel/dist/assets/owl.carousel.min.css',
                './resources/assets/js/owl.carousel/dist/assets/owl.theme.default.min.css',
                'frontend/style.css',
                'frontend/photogallery.css',
                './resources/assets/js/dropzone/dist/min/dropzone.min.css',
                './resources/assets/js/select2/dist/css/select2.min.css',
                './resources/assets/js/bootstrap-datepicker/dist/css/bootstrap-datepicker.css',
                './resources/assets/js/sweetalert/dist/sweetalert.css'
            ], 'public/css/frontend.css')
        .scripts([ // Combine front-end scripts
                'jquery/dist/jquery.min.js',
                'bootstrap/dist/js/bootstrap.min.js',
                'plugins.js',
                'plugins.js',
                'vue/dist/vue.js',
                'select2/dist/js/select2.js',
                './resources/assets/js/dropzone/dist/min/dropzone.min.js',
                './resources/assets/js/bootstrap-datepicker/dist/js/bootstrap-datepicker.js',
                './resources/assets/js/sweetalert/dist/sweetalert.min.js',
                './node_modules/socket.io-client/socket.io.js',
                './resources/assets/js/owl.carousel/dist/owl.carousel.min.js',
                'frontend/main.js',
                'backend/main.js',
            ], 'public/js/frontend.js')

        .sass([ // Process back-end stylesheets
            'backend/main.scss',
            'backend/skin.scss',
            'backend/plugin/toastr/toastr.scss',
            './resources/assets/js/select2/src/scss/core.scss',
            './resources/assets/js/bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.css',
            './resources/assets/js/bootstrap-datepicker/dist/css/bootstrap-datepicker.css',
            './resources/assets/js/Ionicons/scss/ionicons.scss',
            'backend/plugin/select2/select2.scss',
            './resources/assets/js/At.js/dist/css/jquery.atwho.css',
            './resources/assets/js/owlcarousel/owl-carousel/owl.carousel.css',
            './resources/assets/js/owlcarousel/owl-carousel/owl.theme.css'
        ], 'resources/assets/css/backend/main.css')
        .styles([ // Combine pre-processed CSS files
                'backend/main.css',
            ], 'public/css/backend.css')
        .copy(
            'resources/assets/sass/backend/plugin/plan/plan.css',
            'public/css/backend/plugin/plan/plan.css'
        )
        .scripts([ // Combine back-end scripts
                'plugins.js',
                'vue/dist/vue.js',
                'backend/main.js',
            './resources/assets/js/bootstrap-datepicker/dist/js/bootstrap-datepicker.js',
                'backend/plugin/toastr/toastr.min.js',
                'bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.all.js',
                'select2/dist/js/select2.js',
                './node_modules/socket.io-client/socket.io.js',
                'Sortable/Sortable.js',
                'Caret.js/dist/jquery.caret.js',
                'owlcarousel/owl-carousel/owl.carousel.js',
                'At.js/dist/js/jquery.atwho.js',
                'backend/custom.js',
            ], 'public/js/backend.js')

        // Apply version control
        .version(["public/css/frontend.css", "public/js/frontend.js", "public/css/backend.css", "public/js/backend.js"]);
});

