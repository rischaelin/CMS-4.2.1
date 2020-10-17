// Plugins
var gulp = require('gulp'),
    autoprefixer = require('gulp-autoprefixer'),
    cache = require('gulp-cache'),
    cleancss = require('gulp-clean-css'),
    imagemin = require('gulp-imagemin'),
    notify = require('gulp-notify'),
    rename = require('gulp-rename'),
    sass = require('gulp-sass'),
    plumber = require('gulp-plumber'),
    sourcemaps = require('gulp-sourcemaps'),
    concat = require('gulp-concat'),
    babel = require('gulp-babel'),
    browserify = require('gulp-browserify'),
    browserSync = require('browser-sync').create();

// Compile all the styles
gulp.task('sass', function () {
    return gulp.src(['assets/scss/main.scss'])
        .pipe(plumber())
        .pipe(sourcemaps.init())
        .pipe(sass({
            outputStyle: 'compressed'
        }).on('error', sass.logError))
        .pipe(sourcemaps.write())
        .pipe(autoprefixer({
            browsers: ['last 3 versions'],
            cascade: false
        }))
        .pipe(gulp.dest('./dist/css/'))
        .pipe(browserSync.reload({
            stream: true
        }))
        .pipe(notify({message: 'SASS/CSS task complete'}));
});

gulp.task('sass:watch', function () {
    gulp.watch(['assets/scss/style.scss', 'assets/scss/**/*.scss'], ['sass']);
});

// Images
gulp.task('images', function () {
    return gulp.src('./assets/images/**')
        .pipe(imagemin([
            imagemin.gifsicle({interlaced: true}),
            imagemin.jpegtran({progressive: true}),
            imagemin.optipng({optimizationLevel: 5}),
            imagemin.svgo({plugins: [{removeViewBox: true}]})
        ]))
        .pipe(gulp.dest('dist/images/'))
        .pipe(notify({message: 'Images task complete'}));
});


gulp.task('js', function () {
    gulp.src('./assets/js/*.js')
        .pipe(sourcemaps.init())
        .pipe(plumber())
        .pipe(concat('global.js'))
        .pipe(babel({
            presets: ['@babel/env']
        }))
        .pipe(browserify({
            insertGlobals: true,
            debug: !gulp.env.production
        }))
        //.pipe(uglify())
        .pipe(rename({suffix: '.min'}))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('dist/js/'))
        .pipe(browserSync.reload({
            stream: true
        }));

    gulp.src('./node_modules/jquery/dist/jquery.min.js')
        .pipe(gulp.dest('dist/js/'));

});

// Watch for updates; compile on save
gulp.task('watch', function () {
    // Watch SCSS files
    gulp.watch(['assets/scss/style.scss', 'assets/scss/*/*.scss']);
    gulp.watch('./assets/js/*.js', ['js']);
    // Watch image files
    gulp.watch('assets/images/**', ['images']);
});

gulp.task('default', ['sass:watch', 'images', 'sass', 'js', 'watch'], function () {

    var files = [
        './*.html',
        './**/*.html',
        './assets/scss/main.scss',
        './assets/scss/**/*.scss',
        './assets/js/*.js',
    ];
    browserSync.init(files, {
        server: './',
        injectChanges: true,
        notify: false,
        browser: "google chrome",
        open: false
    });

});