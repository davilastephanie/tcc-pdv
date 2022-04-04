const fs  = require('fs');
const mix = require('laravel-mix');

mix.sass('resources/sass/app.scss', 'public/dist').options({processCssUrls: false});
mix.combine(['resources/js/app.js', 'resources/js/helpers.js'], 'public/dist/app.js');
mix.combine(['resources/js/pdv.js'], 'public/dist/pdv.js');
mix.combine(['resources/js/graph.js'], 'public/dist/graph.js');

mix.disableNotifications();
mix.then(() => {
  if (fs.existsSync('./public/mix-manifest.json')) {
    fs.unlinkSync('./public/mix-manifest.json');
  }
});