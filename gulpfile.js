var gulp         = require( 'gulp' ),
	uglify       = require( 'gulp-uglify' ),
	sass         = require( 'gulp-sass' ),
	autoprefixer = require( 'gulp-autoprefixer' ),
	cssnano      = require( 'gulp-cssnano' ),
	plumber      = require( 'gulp-plumber' ),
	concat       = require( 'gulp-concat' ),
	notify       = require( 'gulp-notify' ),
	sourcemaps   = require( 'gulp-sourcemaps' );

var AdminJS = [
	'./admin/js/src/cl-newspress-admin.js',
];

var PublicJS = [
	'./public/js/src/cl-newspress-public.js',
];

var AdminSCSS = [
	'./vendor/uikit_2/css/uikit.min.css',
	'./admin/css/scss/cl-newspress-admin.scss',
];

var PublicSCSS = [
	'./vendor/uikit_2/css/uikit.min.css',
	'./public/css/scss/cl-newspress-public.scss',
];

/** Js Tasks */
gulp.task( 'admin-scripts', function() {
	return gulp.src( AdminJS )
		.pipe( sourcemaps.init() )
		// An identity sourcemap will be generated at this step
		.pipe( sourcemaps.identityMap() )
		.pipe( plumber() )
		.pipe( concat( 'cl-newspress-admin.min.js' ) )
		.pipe( uglify() )
		.pipe( sourcemaps.write( './maps' ) )
		.pipe( gulp.dest( 'admin/js' ) )
		.pipe( notify( {
			title: 'Resultado tarea Gulp JS:',
			message: 'Admin .min creado',
			onLast: true
		} ) );
} );

gulp.task( 'public-scripts', function() {
	return gulp.src( PublicJS )
		.pipe( sourcemaps.init() )
		// An identity sourcemap will be generated at this step
		.pipe( sourcemaps.identityMap() )
		.pipe( plumber() )
		.pipe( concat( 'cl-newspress-public.min.js' ) )
		.pipe( uglify() )
		.pipe( sourcemaps.write( './maps' ) )
		.pipe( gulp.dest( 'public/js' ) )
		.pipe( notify( {
			title: 'Resultado tarea Gulp JS:',
			message: 'Public .min creado',
			onLast: true
		} ) );
} );

/** SCSS Tasks */
gulp.task( 'admin-scss', function() {
	return gulp.src( AdminSCSS )
		.pipe( sourcemaps.init() )
		// An identity sourcemap will be generated at this step
		.pipe( sourcemaps.identityMap() )
		.pipe( plumber() )
		.pipe( concat( 'cl-newspress-admin.min.css' ) )
		.pipe( sass().on( 'error', sass.logError ) )
		.pipe( autoprefixer( 'last 2 versions', '> 5%', 'not ie 6-9') )
		.pipe( cssnano() )
		.pipe( sourcemaps.write( './maps' ) )
		.pipe( gulp.dest( 'admin/css' ) )
		.pipe( notify( {
			title: 'Resultado tarea Gulp CSS:',
			message: 'Admin .min creado',
			onLast: true
		} ) );
} );

gulp.task( 'public-scss', function() {
	return gulp.src( PublicSCSS )
		.pipe( sourcemaps.init() )
		// An identity sourcemap will be generated at this step
		.pipe( sourcemaps.identityMap() )
		.pipe( plumber() )
		.pipe( concat( 'cl-newspress-public.min.css' ) )
		.pipe( sass().on( 'error', sass.logError ) )
		.pipe( autoprefixer( 'last 2 versions', '> 5%', 'not ie 6-9') )
		.pipe( cssnano() )
		.pipe( sourcemaps.write( './maps' ) )
		.pipe( gulp.dest( 'public/css' ) )
		.pipe( notify( {
			title: 'Resultado tarea Gulp CSS:',
			message: 'Public .min creado',
			onLast: true
		} ) );
} );

gulp.task( 'watch', function() {
	// Inspect changes in js files.
	gulp.watch( AdminJS, gulp.series( 'admin-scripts' ) );
	gulp.watch( PublicJS, gulp.series( 'public-scripts' ) );

	// Inspect changes in scss files.
	gulp.watch( AdminSCSS, gulp.series( 'admin-scss' ) );
	gulp.watch( PublicSCSS, gulp.series( 'public-scss' ) );
} );

gulp.task( 'default', gulp.parallel( 'watch' ) );
