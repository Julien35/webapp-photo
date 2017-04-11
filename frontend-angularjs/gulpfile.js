// NODE plugins
const path = require('path');

const del = require('del');
const runSequence = require('run-sequence');
const browserSync = require('browser-sync');
const plato = require('plato');

const eslintrc = require('./.eslintrc.json');

// GULP plugins
// Source ->
const gulp = require('gulp');
// Source ->
const rename = require('gulp-rename');


// Common plugins
// Source ->
const concat = require('gulp-concat');
// Source -> https://github.com/floridoo/gulp-sourcemaps
const sourcemaps = require('gulp-sourcemaps');


// Assets plugins

// Styles plugins
// Source -> https://github.com/dlmanning/gulp-sass
const sass = require('gulp-sass');
// Source ->
const minify = require('gulp-minify-css');

// Javascript plugins
// Source -> https://github.com/babel/gulp-babel
const babel = require('gulp-babel');
// Source -> https://github.com/terinjokes/gulp-uglify
const uglify = require('gulp-uglify');
// Source -> https://www.npmjs.com/package/gulp-angular-injector
const ngInject = require('gulp-angular-injector');
// Source -> https://github.com/Kagami/gulp-ng-annotate
const ngAnnotate = require('gulp-ng-annotate');

/** TODO
 *  - Should require config file
 */

var dir = {
	src: './app/',
	dst: './dist/'
};

var file = {
	suffix: {
		suffix: '.min'
	},
	script: {
		babel: {
			presets: ['es2015']
		}
	},
	assets: [path.join(dir.src, 'assets/**/*'), path.join(dir.src, '/**/*.html')]
};

var vendors = {
	scripts: [
		'node_modules/angular/angular.js',
		'node_modules/angular-ui-router/release/angular-ui-router.js'
	],
	styles: []
};

var config = {
	plato: {
		src: path.join(dir.src, '**/*.js'),
		out: './extra/plato',
		options: {
			title: 'plato-report.html',
			date: (new Date()).getTime(),
			eslint: eslintrc,
			recurse: true,
			exclude: ''
		}
	}
};

gulp.task('clean:dist', () => {
	return del(dir.dst);
});

gulp.task('clean:extra', () => {
	return del('./extra');
});

gulp.task('copy:assets', () => {
	return gulp.src(file.assets).pipe(gulp.dest(dir.dst));
});


gulp.task('sync:css', () => {
	return gulp.src(path.join(dir.src, 'styles/app.scss'))
		.pipe(rename(file.suffix))
		.pipe(sass())
		.pipe(gulp.dest(path.join(dir.dst, 'styles')))
		.pipe(browserSync.stream());
});

gulp.task('build:css', () => {
	return gulp.src(path.join(dir.src, 'styles/app.scss'))
		.pipe(sourcemaps.init())
		.pipe(sass())
		.pipe(rename(file.suffix))
		.pipe(minify())
		.pipe(sourcemaps.write('./'))
		.pipe(gulp.dest(path.join(dir.dst, 'styles')));
});


gulp.task('sync:js', () => {
	return gulp.src([path.join(dir.src, 'scripts/**/*.js'), path.join(dir.src, 'views/**/*.js')])
		.pipe(babel(file.script.babel))
		.pipe(concat('app.js'))
		.pipe(rename(file.suffix))
		.pipe(gulp.dest(path.join(dir.dst, 'scripts')))
		.pipe(browserSync.stream());
});

gulp.task('live:js:vendors', () => {
	return gulp.src(vendors.scripts)
		// .pipe(babel(file.script.babel))
		.pipe(concat('vendors.js'))
		.pipe(rename(file.suffix))
		.pipe(gulp.dest(path.join(dir.dst, 'scripts')))
		.pipe(browserSync.stream());
});

gulp.task('build:js', () => {
	return gulp.src([path.join(dir.src, 'scripts/**/*.js'), path.join(dir.src, 'views/**/*.js')])
		.pipe(ngAnnotate({ add: true, single_quotes: true }))
		.pipe(babel(file.script.babel))
		.pipe(concat('app.js'))
		.pipe(rename(file.suffix))
		.pipe(sourcemaps.init())
		.pipe(uglify())
		.pipe(sourcemaps.write('./'))
		.pipe(gulp.dest(path.join(dir.dst, 'scripts')));
});

gulp.task('build:js:vendors', () => {
	return gulp.src(vendors.scripts)
		.pipe(concat('vendors.js'))
		.pipe(rename(file.suffix))
		.pipe(uglify())
		.pipe(gulp.dest(path.join(dir.dst, 'scripts')));
});

gulp.task('plato', ['clean:extra'], () => {
	var platoInspect = (resolve) => {
		plato.inspect(config.plato.src, config.plato.out, config.plato.options, () => {
			resolve();
		});
	};
	return new Promise(platoInspect);
});

gulp.task('build:dev', () => {
	return runSequence('clean:dist', ['copy:assets', 'sync:css', 'sync:js', 'live:js:vendors'], watch);
});


gulp.task('build:dist', () => {
	return runSequence('clean:dist', ['copy:assets', 'build:css', 'build:js', 'build:js:vendors']);
});

// Watch
const watch = () => {
	browserSync.init({
		server: dir.dst
	});

	gulp.watch(file.assets, ['copy:assets']).on('change', browserSync.reload);
	gulp.watch(path.join(dir.src, '**/*.scss'), ['sync:css']);
	gulp.watch(path.join(dir.src, '**/*.js'), ['sync:js']);
};
// Global tasks

gulp.task('default', ['build:dev'], function () {});
gulp.task('dist', ['build:dist'], function () {});
