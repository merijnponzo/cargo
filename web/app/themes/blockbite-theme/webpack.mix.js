const mix = require("laravel-mix");
require("tailwindcss")
require("laravel-mix-clean");

// generate mix
mix.setPublicPath("./");
// theme
const path = "dist/";

mix.js("./resources/js/main.js", path);

mix.postCss("./resources/css/main.css", "dist", [
  require("tailwindcss"),
]);

mix.options({
  processCssUrls: false,
});

mix.webpackConfig({
  stats: {
    children: true,
  },
});
// build
if (mix.inProduction()) {
  /* be carefull, since the default settings could erase your entire project */
  mix.clean({
    cleanOnceBeforeBuildPatterns: ["./dist/*"],
  });
  // create manifest
  mix.version();
  mix.then(() => {
    const convertToFileHash = require("laravel-mix-make-file-hash");
    convertToFileHash({
      publicPath: "./",
      manifestFilePath: "mix-manifest.json"
    });
  });
}
mix.browserSync({
  watch: true,
  proxy: process.env.MIX_APP_HOST,
  host: process.env.MIX_APP_HOST,
  files: [
    "./**/*.php",
    "./**/*.html",
    "./resources/**/*.css",
    "./resources/**/*.js",
    "./blocks/**/*.css",
    "./blocks/**/*.js"
  ],
});
