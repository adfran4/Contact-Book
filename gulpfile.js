'use strict';

var gulp = require('gulp');
var jshint = require('gulp-jshint');
var sass = require('gulp-sass');
var sourcemaps = require('gulp-sourcemaps');
var browserSync = require('browser-sync').create();


require('es6-promise').polyfill();

var postcss      = require('gulp-postcss');
var autoprefixer = require('autoprefixer');

// Gulp jshint
gulp.task('jshint',function(){
	  return gulp.src('js/**/*.js')
	  .pipe(jshint())
	  .pipe(jshint.reporter('default'))
});

// Static Server + watching scss/html files
gulp.task('serve', ['sass'], function() {

    browserSync.init({
        server: ".",
        tunnel: "coderslab2",
    }); 

    gulp.watch("sass/**/*.scss", ['sass']);
    gulp.watch("js/**/*.js", ['jshint']);
		gulp.watch("*.php").on('change', browserSync.reload);
});

// Compile sass into CSS & auto-inject into browsers
gulp.task('sass', function() {
    return gulp.src("sass/**/*.scss")
    	.pipe(sourcemaps.init())
        .pipe(sass({
         errLogToConsole: true,
         outputStyle: 'compressed',
        }).on('error', sass.logError))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest("css/"))
        .pipe(browserSync.stream({match: '**/*.css'}));
});

gulp.task('autoprefixer', function () {

    return gulp.src('css/*.css')
        .pipe(sourcemaps.init())
        .pipe(postcss([ autoprefixer({ browsers: ['last 2 versions'] }) ]))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('css/'));
});


gulp.task('default', ['serve']);
