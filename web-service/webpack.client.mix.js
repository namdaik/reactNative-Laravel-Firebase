const config = require('./webpack.client.config');
const mix = require('laravel-mix');
require('laravel-mix-eslint');
require('laravel-mix-merge-manifest');

function resolve(dir) {
  return path.join(
    __dirname,
    '/resources/js/client',
    dir
  );
}

Mix.listen('configReady', webpackConfig => {
  const imageLoaderConfig = webpackConfig.module.rules.find(
    rule =>
      String(rule.test) ===
      String(/(\.(png|jpe?g|gif|webp)$|^((?!font).)*\.svg$)/)
  );
  imageLoaderConfig.exclude = resolve('icons');
});

mix.webpackConfig(config);

mix
  .js('resources/js/client.js', 'public/js/client/index.js')
  .extract([
    'vue',
    'axios',
    'vuex',
    'vue-router',
    'vue-i18n',
    'element-ui',
    'xlsx',
  ])
  .mergeManifest()
  .options({
    processCssUrls: false,
  })
  .sass('resources/js/client/styles/index.scss', 'public/css/client/index.css', {
    implementation: require('node-sass'),
  });

if (mix.inProduction()) {
  mix.version();
} else {
  if (process.env.LARAVUE_USE_ESLINT === 'true') {
    mix.eslint();
  }

  mix
    .sourceMaps()
    .webpackConfig({
      devtool: 'cheap-eval-source-map',
    });
}
