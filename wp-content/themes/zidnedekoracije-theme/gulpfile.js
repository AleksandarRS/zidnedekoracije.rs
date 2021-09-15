let project_name = 'zidnedekoracije.rs';

let gulp            = require('gulp'),                          // Gulp of-course
	autoprefixer    = require('autoprefixer'),             // Autoprefixing magic.
	notify          = require('gulp-notify'),                   // Sends message notification to you for plumber
	sourcemaps      = require('gulp-sourcemaps'),               // Maps code in a compressed file (E.g. style.css) back to it’s original position in a source file 	(E.g. structure.scss, which was later combined with other css files to generate style.css)
	sass            = require('gulp-sass'),                     // Gulp pluign for Sass compilation.
	concat          = require('gulp-concat'),                   // Concatenates JS files
	uglify          = require('gulp-uglify'),                   // Minifies JS files
	browserSync     = require('browser-sync').create(),         // Reloads browser and injects CSS. Time-saving synchronised browser testing.
	mmq             = require('gulp-merge-media-queries'),      // Combine matching media queries into one media query definition.
	minifycss       = require('gulp-uglifycss'),                // Minifies CSS files.
	lineec          = require('gulp-line-ending-corrector'),    // Consistent Line Endings for non UNIX systems. Gulp Plugin for Line Ending Corrector (A utility that makes sure your files have consistent line endings)
	imagemin        = require('gulp-imagemin'),                 // Image optimization
	pngcrush        = require('imagemin-pngcrush'),             // Image optimization
	plumber          = require('gulp-plumber'), 
	buffer           = require('vinyl-buffer'),
	source           = require('vinyl-source-stream'),
	browserify       = require('browserify'),
	babel            = require('gulp-babel'),
	postcss          = require('gulp-postcss'),
	flexBugsFix      = require('postcss-flexbugs-fixes'),
	path             = require('path'),
	sassLint         = require('gulp-sass-lint'),
	gutil            = require('gulp-util'),
	clean            = require('gulp-clean'),
	filter           = require('gulp-filter'), // Enables you to work on a subset of the original files by filtering them using globbing.
	eslint 			 = require('gulp-eslint'),
	cleanCss		 = require('gulp-clean-css'),
	iconfont         = require('gulp-iconfont'),
	iconfontCss      = require('gulp-iconfont-css');


let config = (function(){

	return {
		scss: {
			src: './assets/scss/style.scss',
			dist: 'dist',
			watch: [
				'assets/scss/**/**/**/*.scss',
				'assets/scss/**/**/*.scss',
				'assets/scss/**/*.scss',
				'assets/scss/*.scss',
			],
		},
		js: {
			src: 'assets/js/site.js',
			dist: 'dist',
			watch: [
				'assets/js/**/*.js',
				'assets/js/**/**/*.js'
			],
		},
	
		/***********************************************************************
		/** Translation related; NOTE: Leave empty to inherit from project_name above
		/***********************************************************************/
		text_domain: '' || project_name, // Example: 'magicwalls' #lowercase, separated by underscore or dash ( _ or - )
		packageName: '' || project_name, // Example: 'magicwalls package' #Capitalized
	
		flags: {
			production: !!gutil.env.production,
		},
		browserSyncOptions: {
			proxy: 'http://localhost/' + project_name,
			open: true,
			injectChanges: true,
			ghostMode: false,
		},
		plumberMessageError: {
			errorHandler: notify.onError({
				title: 'Fix that ERROR:',
				message: "<%= error.message %>",
				icon: path.join(__dirname, 'assets/images/error.png'),
				time: 2000
			})
		},
		prefixOptions: [
			autoprefixer({ browsers: ['last 3 versions', 'ios >= 6'] }),
			flexBugsFix
		],
		uploads_dir:  {
			files: '../../uploads/**',
			filesDest: '../../uploads/**',
		},
	};
})();

function browser_sync( cb ) {
	browserSync.init( config.browserSyncOptions );
	cb();
};

function css() {

	 return gulp
				.src( config.scss.src, { allowEmpty: true } )
				.pipe( !config.flags.production ? sourcemaps.init() : gutil.noop() )
				.pipe(sassLint({
					configFile: 'sass-lint.yml',
				}))
				.pipe( sassLint.format())
				.pipe( plumber(config.plumberMessageError) )
				.pipe( sass({outputStyle: !config.flags.production ? 'expanded' : 'compressed' }) )
				.pipe( postcss(config.prefixOptions))
				.pipe( !config.flags.production ? sourcemaps.write('.') : gutil.noop() )
				.pipe( gulp.dest( config.scss.dist ) )
				.pipe( mmq({ log: false }))
				.pipe( lineec()) // Consistent Line Endings for non UNIX systems.
				.pipe( config.flags.production ? minifycss() : gutil.noop() )
				.pipe( cleanCss({compatibility: 'ie8'}))
				.pipe( filter('**/*.css')) // Filtering stream to only css files
				.pipe( browserSync.stream() ); // Reloads style.css if that is enqueued.

};

// Concatenate plugins and libs files into one file so we can mege it with site.js (this file will be deleted)
function plugins_js() {
		return gulp
				.src([
					'assets/js/plugins/*.js',
				], { allowEmpty: true })
				.pipe(concat('plugins.js'))
				.pipe(gulp.dest( config.js.dist ));
};

function site_js() {

	return browserify( config.js.src, { allowEmpty: true } )
			.bundle()
			.pipe(source('site.js'))
			.pipe(buffer())
			.pipe(babel({ presets: ['es2015'], compact: false }))
			.pipe(browserSync.stream())
			.pipe(gulp.dest( config.js.dist ));
};

function merge_js( ) {
	return gulp
		.src([
			'dist/plugins.js',
			'dist/site.js'
		], { allowEmpty: true })
		.pipe(plumber(config.plumberMessageError))
		.pipe(!config.flags.production ? sourcemaps.init() : gutil.noop() )
		.pipe(concat('scripts.js'))
		.pipe(!config.flags.production ? sourcemaps.write('.') : gutil.noop() )
		.pipe(config.flags.production ? uglify() : gutil.noop() )
		.pipe(browserSync.stream())
		.pipe(gulp.dest( config.js.dist ));

};

function files( cb ) {

	if( config.flags.production ){

		gulp.src(config.uploads_dir.files, { base: config.uploads_dir.files, allowEmpty: true })
			.pipe(imagemin({
				interlaced: true,
				progressive: true,
				optimizationLevel: 7,
				svgoPlugins: [{ removeViewBox: false }],
				use: [pngcrush()]
			}))
			.pipe(gulp.dest(config.uploads_dir.filesDest));
	} 
	
	cb();
}

function environment( cb ){
	if( config.flags.production ){
		gutil.log("\n");
		gutil.log("\n");
		gutil.log("\n");
		gutil.log("\n");
		gutil.log("\n");
		gutil.log("\n");
		gutil.log("\n");
		gutil.log("\n");
		gutil.log("************************************************");
		gutil.log("************ PRODUCTION BUILD ******************");
		gutil.log("************************************************");
	}

	cb();
}

//watch
function watch( cb ) {

	gulp.watch(config.scss.watch, { delay: 0 }, css );
	gulp.watch(config.js.watch, gulp.series( site_js, merge_js, js_lint )  );

	cb();
};

function post_build( cb ){
	if( config.flags.production ){

		gulp
			.src([
				'dist/scripts.js.map', 
				'dist/style.css.map',
				'dist/plugins.js',
				'dist/site.js',
			], { allowEmpty: true, read: false})
			.pipe(clean());
	}

	cb();
}

//icon fonts
function fonticons() {

	return gulp.src(['assets/icons/*.svg'])

		.pipe(iconfontCss({
			fontName: 'font-icons',
			cssClass: 'icon',
			path: 'assets/scss/utilities/_icon-font-config.scss',
			targetPath: '../../scss/general/_icon-font.scss',
			fontPath: '../assets/fonts/font-icons/'
		}))
		.pipe(iconfont({
			fontName: 'font-icons', 
			prependUnicode: true,
			formats: ['woff2', 'woff', 'ttf'],
			normalize: true,
			// fontHeight: 1000,
			centerHorizontally: true
		}))
		.pipe(gulp.dest('assets/fonts/font-icons/'))
}

function js_lint(){
	return gulp.src(config.js.watch).pipe(eslint({
		configFile: 'eslintrc.json',
		fix: true,
	}))
	.pipe(eslint.formatEach('compact', process.stderr))
}

exports.default = gulp.series( environment, js_lint, plugins_js, site_js, merge_js, css, watch, files, post_build, browser_sync );
exports.fonticons = fonticons;