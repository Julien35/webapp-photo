var Encore = require('@symfony/webpack-encore');

Encore
// the project directory where compiled assets will be stored
    .setOutputPath('public/build/')

    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')

    .cleanupOutputBeforeBuild()

    .autoProvidejQuery()

    // uncomment if you use Sass/SCSS files
    .enableSassLoader()
    // parameters are not mandatory, only if webpack build is slow with bootstrap (http://symfony.com/doc/current/frontend/encore/bootstrap.html)
    .enableSassLoader(function(sassOptions) {}, {
        resolveUrlLoader: false,
    })

    .enableSourceMaps(!Encore.isProduction())

    // uncomment to create hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    .enableVueLoader()

    // uncomment to define the assets of the project
    .addEntry('index',
        [
            './assets/vuejs/main.js',
            './assets/scss/index.scss'
        ])

    // this creates a 'vendors.js' file with JS modules (jquery, bootstrap.js, ...)
    // this creates a 'vendors.css' file with vendors CSS (bootstrap, fontawsome..)
    .createSharedEntry('vendors', [
        'jquery',
        'popper.js',
        'bootstrap',

        'braintree-web',
        'braintree-web-drop-in',
        // '@fortawesome/fontawesome',
        // '@fortawesome/vue-fontawesome',
        // '@fortawesome/fontawesome-free-brands',
        // '@fortawesome/fontawesome-free-solid',
        // '@fortawesome/fontawesome-free-webfonts',

        'bootstrap/scss/bootstrap.scss',
        '@fortawesome/fontawesome-free-webfonts/css/fa-solid.css',
        '@fortawesome/fontawesome-free-webfonts/css/fa-regular.css',
        '@fortawesome/fontawesome-free-webfonts/css/fa-brands.css',
        '@fortawesome/fontawesome-free-webfonts/css/fontawesome.css',
    ])
;

module.exports = Encore.getWebpackConfig();
