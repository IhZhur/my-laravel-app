const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .react() // Поддержка React
   .postCss('resources/css/app.css', 'public/css', [
      //
   ]);

if (mix.inProduction()) {
    mix.version();
}
