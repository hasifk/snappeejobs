var elixir = require('laravel-elixir');

elixir(function(mix) {
    mix
        .phpUnit()

        // Copy webfont files from /vendor directories to /public directory.
        .copy('vendor/fortawesome/font-awesome/fonts', 'public/build/fonts/font-awesome')
        .copy('vendor/twbs/bootstrap-sass/assets/fonts/bootstrap', 'public/build/fonts/bootstrap')
        .copy('vendor/twbs/bootstrap/dist/js/bootstrap.min.js', 'public/js/vendor')
        .copy('./resources/assets/js/Ionicons/fonts', 'public/build/fonts')

        .sass([ // Process front-end stylesheets
                'frontend/main.scss'
            ], 'resources/assets/css/frontend/main.css')
        .styles([  // Combine pre-processed CSS files
                'frontend/main.css',
                './resources/assets/js/dropzone/dist/min/dropzone.min.css'
            ], 'public/css/frontend.css')
        .scripts([ // Combine front-end scripts
                'plugins.js',
                'frontend/main.js',
                'vue/dist/vue.js',
                './resources/assets/js/dropzone/dist/min/dropzone.min.js'
            ], 'public/js/frontend.js')

        .sass([ // Process back-end stylesheets
            'backend/main.scss',
            'backend/skin.scss',
            'backend/plugin/toastr/toastr.scss',
            './resources/assets/js/select2/src/scss/core.scss',
            './resources/assets/js/bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.css',
            './resources/assets/js/Ionicons/scss/ionicons.scss',
            'backend/plugin/select2/select2.scss',
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
                'backend/main.js',
                'backend/plugin/toastr/toastr.min.js',
                'bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.all.js',
                'select2/dist/js/select2.js',
                'backend/custom.js'
            ], 'public/js/backend.js')

        // Apply version control
        .version(["public/css/frontend.css", "public/js/frontend.js", "public/css/backend.css", "public/js/backend.js"]);
});

