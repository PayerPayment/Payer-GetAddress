var gulp                = require('gulp');
var sourcemaps          = require('gulp-sourcemaps');
var gutil               = require("gulp-util");
var webpack             = require("webpack");
var path_node           = require('path');
var WebpackDevServer    = require("webpack-dev-server");
var webpackConfig       = require("./webpack.config.js");
var stream              = require('webpack-stream');

var path = {
    ALL: ['resources/scripts/**/*.es6', 'resources/scripts/**/*.js'],
    DEST: 'src'
};

gulp.task('webpack', [], function() {
    return gulp.src(path.ALL)
        .pipe(sourcemaps.init())
        .pipe(stream(webpackConfig))
        .pipe(sourcemaps.write())
        .pipe(gulp.dest(path.DEST + '/scripts'));
});

gulp.task("webpack-dev-server", function(callback) {
    // modify some webpack config options
    var myConfig = Object.create(webpackConfig);
    myConfig.devtool = "eval";
    myConfig.debug = true;

    // Start a webpack-dev-server
    var compiler = webpack(myConfig);
    new WebpackDevServer(webpack(myConfig), {
        publicPath: "/" + myConfig.output.publicPath,
        stats: {
            colors: true
        }
    }).listen(4000, "localhost", function(err) {
        if (err) throw new gutil.PluginError("webpack-dev-server", err);
        gutil.log("[webpack-dev-server]", "http://localhost:4000/webpack-dev-server/demo.html");
    });
});

gulp.task('watch', function() {
    gulp.watch(path.ALL, ['webpack']);
});

gulp.task('default', ['webpack', 'webpack-dev-server', 'watch']);