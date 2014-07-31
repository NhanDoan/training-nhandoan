(function(gulp, gulpLoadPlugins) {
	'use strict';
	//|**
	//|
	//| Gulpfile
	//|
	//| This file is the streaming build system
	//|
	//| .--------------------------------------------------------------.
	//| | NAMING CONVENTIONS:                                          |
	//| |--------------------------------------------------------------|
	//| | Singleton-literals and prototype objects | PascalCase        |
	//| |--------------------------------------------------------------|
	//| | Functions and public variables           | camelCase         |
	//| |--------------------------------------------------------------|
	//| | Global variables and constants           | UPPERCASE         |
	//| |--------------------------------------------------------------|
	//| | Private variables                        | _underscorePrefix |
	//| '--------------------------------------------------------------'
	//|
	//| Comment syntax for the entire project follows JSDoc:
	//| - http://code.google.com/p/jsdoc-toolkit/wiki/TagReference
	//|
	//| For performance reasons we're only matching one level down:
	//| - 'test/spec/{,*/}*.js'
	//|
	//| Use this if you want to recursively match all subfolders:
	//| - 'test/spec/**/*.js'
	//|
	//'*/
	var $ = gulpLoadPlugins({
			pattern: 'gulp-*',
			lazy: true,
			// scope: ['devDependencies']
		}),
		_ = {
			devServerPort: 9000,
			app: 'app',
			paths: {
				scripts: ['app/js/app.js', 'app/js/**/*.{js}'], // # All .js and .coffee files, starting with app.coffee or app.js
				styles: 'app/css/**/*.{scss,css}', // css and scss files
				pages: 'app/pages/*.{html,slim}', // All html, jade,and markdown files that can be reached directly
				templates: 'app/templates/**/*.{html,slim}', // All html, jade, and markdown files used as templates within the app
				images: 'app/img/*.{png,jpg,jpeg,gif}', // All image files
				'static': 'app/static/*.*' // Any other static content such as the favicon
			},
			vendor: {
				scripts: [
					'vendor/bower/jquery/jquery.js',
					'vendor/bower/lodash/dist/lodash.js',
					'vendor/bower/angular/angular.js',
					'vendor/bower/angular-ui-router/release/angular-ui-router.js',
					'vendor/bower/angular-bootstrap/ui-bootstrap.js',
					'vendor/bower/angular-bootstrap/ui-bootstrap-tpls.js'
				],
				styles: [], // Bootstrap and Font-Awesome are included using @import in main.scss
				fonts: ['vendor/bower/font-awesome/fonts/*.*']
			}
		};

	// Included gulp compoent not suport name convension
	// =================================================
	$.gulpif = require('gulp-if');
	$.htmlify = require('gulp-angular-htmlify');
	$.gutil = require('gulp-util');
	$.gulpif = require('gulp-if');
	$.templateCache = require('gulp-angular-templatecache');
	$.sass = require('gulp-ruby-sass');
	$.pngcrush = require('imagemin-pngcrush');
	// $.imagemin = require('gulp-imagemin');
	$.streamqueue = require('streamqueue');
	$.minifyCSS = require('gulp-minify-css');
	$.minifyHTML = require('gulp-minify-html');
	// $.ngAnnotate = require('gulp-ng-annotate');

	// SCRIPT-RELATED TASKS
	// =================================================
	// Compile, concatenate, and (optionally) minify scripts
	// Also pulls in 3rd party libraries and convertes
	// angular templates to javascript
	// =================================================

	//|**~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	// Gather 3rd party javascripts
	//|**~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	var compileVendorScripts = function() {
		return gulp.src(_.vendor.scripts);
	};

	//|**~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	// Gather and compile App Scripts from coffeescript to JS
	//|**~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	var compileAppScripts = function() {
		return gulp.src(_.paths.scripts)
			// .pipe($.concat('app.js'))
			.pipe($.ngmin());
	};

	//|**~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	// Templates are compiled into JS and placed into Angular's
	// template caching system
	//|**~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	var compileTemplates = function() {
		var templates;
		templates = gulp.src(_.paths.templates)
			.pipe($.if(/[.]slim$/, $.slim()))
			.pipe($.htmlify())
			.pipe($.templateCache({
				root: '/templates/',
				standalone: false,
				module: 'starter-app'
			}));

		return templates;
	};

	//|**~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	// Concatenate all JS into a single file
	// Streamqueue lets us merge these 3 JS sources while maintaining order
	//|**~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	var concatenateAllScripts = function() {
		return $.streamqueue({
			objectMode: true
		}, compileVendorScripts(), compileAppScripts(), compileTemplates()).pipe($.concat('app.js'));
	};

	//|**~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	// Script buiding
	//|**~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	var buildScripts = function(buildPath, minify) {
		var scripts;
		if (buildPath === null || buildPath === undefined) {
			buildPath = 'generated';
		}
		if (minify === null || minify === undefined) {
			minify = false;
		}
		scripts = concatenateAllScripts();
		if (minify) {
			scripts = scripts.pipe($.uglify());
		}
		return scripts.pipe(gulp.dest('' + buildPath + '/js/')).pipe($.connect.reload());
	};

	//|**~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	// Css compile
	//|**~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	var compileCss = function() {
		return gulp.src(_.paths.styles).pipe($.gulpif(/[.]scss$/, $.sass({
			sourcemap: false,
			unixNewlines: true,
			style: 'nested',
			debugInfo: false,
			quiet: false,
			lineNumbers: true,
			bundleExec: true
		}).on('error', $.gutil.log)));
	};

	//|**~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	// Images compressing
	//|**~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	var compressImages = function() {
		return gulp.src(_.paths.images)
			.pipe($.imagemin({
				progressive: true,
				optimizationLevel: 7, // 0,1,2,3,4,5,6,7 n = n*2
				interlaced: true,
				svgoPlugins: [{
					removeViewBox: false
				}],
				use: [$.pngcrush({
					reduce: true
				})]
			}));
	};

	//|**~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	// Images buiding
	//|**~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	var buildImages = function(buildPath) {
		if (buildPath === null || buildPath === undefined) {
			buildPath = 'generated';
		}
		return compressImages().pipe(gulp.dest(buildPath + '/img/')).pipe($.connect.reload());
	};

	//|**~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	// Styles buiding
	//|**~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	var buildStyles = function(buildPath, minify) {
		var styles;
		if (buildPath === null || buildPath === undefined) {
			buildPath = 'generated';
		}
		if (minify === null || minify === undefined) {
			minify = false;
		}
		styles = compileCss().pipe($.concat('app.css'));
		if (minify) {
			styles = styles.pipe($.minifyCSS());
		}
		return styles.pipe(gulp.dest('' + buildPath + '/css/')).pipe($.connect.reload());
	};

	//|**~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	// Fonts buiding
	//|**~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	var buildFonts = function(buildPath) {
		if (buildPath === null || buildPath === undefined) {
			buildPath = 'generated';
		}
		return gulp.src(_.vendor.fonts).pipe(gulp.dest('' + buildPath + '/fonts/'));
	};

	//|**~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	// Static files buiding
	//|**~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	var buildStatic = function(buildPath) {
		if (buildPath === null || buildPath === undefined) {
			buildPath = 'generated';
		}
		return gulp.src(_.paths['static'])
			.pipe(gulp.dest(buildPath + '/static/'))
			.pipe($.connect.reload());
	};

	//|**~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	// Pages compile include html, slim, others
	//|**~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	var compilePages = function() {
		return gulp.src(_.paths.pages)
			.pipe($.gulpif(/[.]slim$/, $.slim({
				pretty: true
			})))
			.pipe($.htmlify());
	};

	//|**~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	// Pages building
	//|**~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	var buildPages = function(buildPath, minify) {
		var pages;
		if (buildPath === null || buildPath === undefined) {
			buildPath = 'generated';
		}
		if (minify === null || minify === undefined) {
			minify = false;
		}
		pages = compilePages();
		if (minify) {
			pages = pages.pipe($.minifyHTML());
		}
		return pages.pipe(gulp.dest(buildPath)).pipe($.connect.reload());
	};

	// TASK REGISTER
	// =============

	//|**~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	// script
	//|**~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	gulp.task('scripts', function() {
		return buildScripts();
	});

	//|**~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	// deploy
	//|**~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	gulp.task('deploy_scripts', function() {
		return buildScripts('deploy', true);
	});

	gulp.task('styles', function() {
		return buildStyles();
	});

	gulp.task('deploy_styles', function() {
		return buildStyles('deploy', true);
	});

	gulp.task('fonts', function() {
		return buildFonts();
	});

	gulp.task('static', function() {
		return buildStatic();
	});

	gulp.task('deploy_static', function() {
		return buildStatic('deploy');
	});

	gulp.task('images', function() {
		return buildImages();
	});

	gulp.task('deploy_images', function() {
		return buildImages('deploy');
	});

	gulp.task('fonts', function() {
  return buildFonts();
	});

	gulp.task('deploy_fonts', function() {
	  return buildFonts('deploy');
	});


	gulp.task('pages', function() {
		return buildPages();
	});

	gulp.task('deploy_pages', function() {
		return buildPages('deploy', true);
	});

	gulp.task('clean_deploy', function() {
		gulp.src('./deploy/**', {read: false})
		.pipe($.rimraf());
	});

	gulp.task('clean', function() {
		$.rimraf('generated');
	});

	gulp.task('watch', function() {
		gulp.watch([_.paths.scripts, _.paths.templates, _.vendor.scripts], ['scripts']);
		gulp.watch([_.paths.styles, _.vendor.styles], ['styles']);
		gulp.watch([_.paths.pages], ['pages']);
		gulp.watch([_.paths.images], ['images']);
		gulp.watch([_.vendor.fonts], ['fonts']);
		return gulp.watch([_.paths['static']], ['static']);
	});

	gulp.task('server', function() {
		return $.connect.server({
			root: ['generated'],
			port: _.devServerPort,
			livereload: true,
			middleware: function() {
				return [
					(function() {
						var options, proxy, url;
						url = require('url');
						proxy = require('proxy-middleware');
						options = url.parse('http://localhost:3000/');
						options.route = '/api';
						return proxy(options);
					})()
				];
			}
		});
	});

	gulp.task('compile', ['clean'], function() {
		return gulp.start('scripts', 'styles', 'pages', 'images', 'fonts', 'static');
	});

	gulp.task('deploy', ['clean_deploy'], function() {
		return gulp.start('deploy_scripts', 'deploy_styles', 'deploy_pages', 'deploy_images', 'deploy_fonts', 'deploy_static');
	});

	gulp.task('default', ['clean'], function() {
		return gulp.start('scripts', 'styles', 'pages', 'images', 'fonts', 'static', 'server', 'watch');
	});

}(require('gulp'), require('gulp-load-plugins')));
