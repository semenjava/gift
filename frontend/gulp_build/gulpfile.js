'use strict';

var path = {
	build : {
		js : '../assets/js/',
		css : '../assets/css/',
		assets : '../../assets/',
	},
	src: {
		css : {
			library : 'assets/css/library/',
			work : 'assets/css/work/',
		},
		js : {
			library : 'assets/js/library/',
			work : 'assets/js/work/',
		},
		bootstrap : 'assets/bootstrap/',
	},
};

var gulp = require('gulp'),
    cleanCSS = require('gulp-clean-css'),
    rimraf = require('rimraf'),
    rename = require("gulp-rename"),
    less = require('gulp-less'),
    watch = require('gulp-watch');

gulp.task('watch-css', function () {
	gulp.watch(path.src.css.work + '*.less', ['less']);
});

gulp.task('build-bootstrap', function () {
    return gulp.src(path.src.bootstrap + 'bootstrap.less')
      // .pipe(plumber())
      .pipe(less({
          // paths: [path.join(__dirname, 'less', 'includes')]
      }))
      .pipe(gulp.dest(path.build.css));
});


gulp.task('clean-css', function (cb) {
	rimraf(path.build.css + '*', cb);
});
gulp.task('clean-js', function (cb) {
	rimraf(path.build.js + '*', cb);
});
gulp.task('clean-assets', function (cb) {
	rimraf(path.build.assets + '*', cb);
});

gulp.task('less', function () {
	gulp.src(path.src.css.work + '*.less')
		.pipe(less())
		// .pipe(rename({
		// 		suffix: '.min'
		// }))
		// .pipe(cleanCSS())
		.pipe(gulp.dest(path.build.css));
});

gulp.task('style:build', function () {
	gulp.src(path.src.css.library + '*.css')
		.pipe(gulp.dest(path.build.css));
	gulp.src(path.src.css.work + '*.css')
		// .pipe(rename({
		// 		suffix: '.min'
		// }))
		// .pipe(cleanCSS())
		.pipe(gulp.dest(path.build.css));
	gulp.src(path.src.js.library + '*.js')
		.pipe(gulp.dest(path.build.js));
	gulp.src(path.src.js.work + '*.js')
		.pipe(gulp.dest(path.build.js));
});

gulp.task('build', [
	'style:build',
]);

gulp.task('default', ['build', 'less']);
gulp.task('rebuild', ['clean-css', 'clean-js', 'clean-assets', 'build-bootstrap', 'style:build', 'less']);
