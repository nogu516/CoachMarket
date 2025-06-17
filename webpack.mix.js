const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
    ])
    .version();

mix.webpackConfig({
    resolve: {
        fallback: {
            fs: false,
            path: require.resolve('path-browserify'),
            os: require.resolve('os-browserify/browser'),
            stream: require.resolve('stream-browserify'),
            buffer: require.resolve('buffer/'),
            util: require.resolve('util/'),
            crypto: require.resolve('crypto-browserify'),
            vm: require.resolve('vm-browserify'),
            zlib: require.resolve('browserify-zlib'),
        }
    }
});
