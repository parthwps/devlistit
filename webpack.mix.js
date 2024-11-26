const mix = require('laravel-mix');
const glob = require('glob');

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

// mix.js('resources/js/app.js', 'public/js')
//   .postCss('resources/css/app.css', 'public/css', [
//     //
//   ]);



// Load all JS files from public/assets/js
mix.scripts(glob.sync('public/assets/js/**/*.js'), 'public/assets/js/all.js').minify('public/assets/js/all.js');

// Load all CSS files from public/assets/css
mix.styles(glob.sync('public/assets/css/**/*.css'), 'public/assets/css/all.css').minify('public/assets/css/all.css');

