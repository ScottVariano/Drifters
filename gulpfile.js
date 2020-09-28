// Use this command to quickly install NPM and necessary packages:
// npm install gulp gulp-sass jshint gulp-autoprefixer gulp-concat gulp-minify gulp-clean-css

// Import Packages
var gulp = require('gulp');
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
var concat = require('gulp-concat');
var minify = require('gulp-minify');
var cleanCss = require('gulp-clean-css');

// Path to Files
var pathSass = './src/sass/';
var pathJs = './src/js/';

// SASS Files
var sassHead = pathSass + 'head.scss';
var sassBootstrap = pathSass + 'bootstrap.min.scss';
var sassAnimate = pathSass + 'animate.min.scss';
var sassStyle = pathSass + 'style.scss';

// JS Files
var jsBootstrap = pathJs + 'bootstrap.min.js';
var jsWow = pathJs + 'wow.min.js';
var jsTheme = pathJs + 'theme.js';

// Combine and Minify CSS
function styles(){
	return gulp.src([sassHead, sassBootstrap, sassAnimate, sassStyle])
		.pipe(sass())
		.pipe(cleanCss({compatibility: 'ie8'}))
		.pipe(autoprefixer({
            overrideBrowserslist: ['last 2 versions'],
            cascade: false
        }))
		.pipe(concat('style.css', {newLine: '\n\n'}))
		.pipe(gulp.dest('./'));
}

// Combine and Minify JS
function js(){
	return gulp.src([jsBootstrap, jsWow, jsTheme])
		.pipe(minify({
	        ext:{
	            min:'.js'
	        },
	        noSource: true
	        // exclude: ['tasks']
    	}))
		.pipe(concat('theme.js', {newLine: '\n\n'}))
		.pipe(gulp.dest('./'));
}

// Watch Task
function watch(){
	gulp.watch('./src/sass/*.scss', styles);
	gulp.watch('./src/js/*.js', js);
}

// Default Gulp Task
var build = gulp.parallel(styles, js, watch);
gulp.task(build);
gulp.task('default', build);