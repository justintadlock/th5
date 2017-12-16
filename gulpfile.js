const gulp     = require( 'gulp' );
const sass     = require( 'gulp-sass' );
const cssnano  = require( 'gulp-cssnano' );
const rename   = require( 'gulp-rename' );
const uglify   = require( 'gulp-uglify' );
const plumber  = require( 'gulp-plumber' );
const pump     = require( 'pump' );
const imagemin = require( 'gulp-imagemin' );

// Location of the Sass input and the CSS output.
var sassInput = 'assets/sass/**/*.scss';
var cssOutput = '.';

// Set up a styles task. This takes Sass files, turns them into CSS,
// minifies them, and outputs in the CSS output folder.
gulp.task( 'styles', function() {

	gulp.src( sassInput )
		.pipe( sass().on( 'error', sass.logError ) )
		.pipe( cssnano() )
		.pipe( rename( { suffix : '.min' } ) )
		.pipe( gulp.dest( cssOutput ) );
} );

// Location of the JS input and output.
var jsInput  = 'assets/js/**/*.js';
var jsOutput = 'assets/dist/js';

gulp.task( 'scripts', function() {

	gulp.src( jsInput )
	//	.pipe( plumber( { errorHandler : handleErrors } ) )
		.pipe( rename( { suffix : '.min' } ) )
		.pipe( uglify().on('error', function( e ) { console.log( e ); } ) )
		.pipe( gulp.dest( jsOutput ) );
} );

// Location of the image input and output.
var imgInput  = 'assets/img/**/*.{png,gif,jpg}';
var imgOutput = 'assets/dist/img';

gulp.task( 'images', function() {

	gulp.src( imgInput )
		.pipe( imagemin() )
		.pipe( gulp.dest( imgOutput ) );
} );

// Set up a watch task.
gulp.task( 'watch', [ 'styles', 'scripts' ], function() {

	gulp.watch( sassInput, [ 'styles' ] );
	gulp.watch( jsInput, [ 'scripts' ] );
} );
