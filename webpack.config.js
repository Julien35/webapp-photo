const Encore = require('@symfony/webpack-encore');
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');

Encore
// the project directory where compiled assets will be stored
    .setOutputPath('public/build/')

    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')

    .cleanupOutputBeforeBuild()

    // first, install any presets you want to use (e.g. yarn add babel-preset-es2017)
    // then, modify the default Babel configuration
    .configureBabel(function (babelConfig) {

        // console.log('babelConfig.presets[0] : ', babelConfig.presets[0]);
        //todo: fix uglify message bug on yarn build

        Object.assign(babelConfig, {
            presets: [
                ['env', {
                    // modules don't need to be transformed - webpack will parse
                    // the modules for us. This is a performance improvement
                    // https://babeljs.io/docs/plugins/preset-env/#optionsmodules
                    modules: false,
                    targets: {
                        browsers: '> 1%',
                        uglify: false
                    },
                    useBuiltIns: true
                }]
            ],
            plugins: [
                // new UglifyJsPlugin()
            ]
        });

        // console.log('babelConfig.presets[0] : ', babelConfig.presets[0]);
    })

    .configureUglifyJsPlugin(function(options) {
        options.ecma ='5';
        // options already has our default values
        console.log(options);

    })

    .autoProvidejQuery()

    // uncomment if you use Sass/SCSS files
    // .enableSassLoader()
    // parameters are not mandatory, only if webpack build is slow with bootstrap (http://symfony.com/doc/current/frontend/encore/bootstrap.html)
    .enableSassLoader(function (sassOptions) {
    }, {
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
