const mix = require('laravel-mix');

// Compile JavaScript
mix.js('resources/js/app.js', 'public/js')
   .vue() // Enable Vue.js support
   .react() // Enable React support (if you're using React)
   .sass('resources/sass/app.scss', 'public/css')
   .version() // Versioning for cache busting

// Additional custom asset management (if you have extra assets)
mix.copyDirectory('resources/images', 'public/images') // Copy images folder
   .copyDirectory('resources/fonts', 'public/fonts'); // Copy fonts folder

// If you use less or other preprocessors, you can also add those here
// mix.less('resources/less/app.less', 'public/css');
