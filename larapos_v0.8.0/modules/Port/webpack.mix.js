const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.setPublicPath('../../public').mergeManifest();

mix
  .js(__dirname + '/Resources/js/app.js', 'js/port.js')
  .postCss(__dirname + '/Resources/css/app.css', 'css/port.css', [require('tailwindcss')]);

if (mix.inProduction()) {
  mix.version();
}
