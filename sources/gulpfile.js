const { src, dest, watch, series } = require('gulp');
const sass = require('gulp-sass')(require('sass'));;
const postcss = require('gulp-postcss');
const cssnano = require('cssnano');
const concat = require('gulp-concat');
const minify = require('gulp-minify');
const rename = require('gulp-rename');

function scssTask(){
  return src(['scss/*.scss', 'scss/**/*scss'], { sourcemaps: false })
      .pipe(sass())
      .pipe(postcss([cssnano()]))
	  .pipe(rename({suffix: '.min'}))
      .pipe(dest('../css', { sourcemaps: '.' }));
}

function jsTask(){
  return src(['scripts/*', 'scripts/**/*.js'])
	.pipe(concat('main.js'))
    .pipe(minify())	
    .pipe(dest('../scripts'));
	
}

function watchTask(){
  watch(['scss/*.scss', 'scss/**/*scss', 'scripts/*.js', 'scripts/**/*.js'], series(scssTask, jsTask)); 
}

exports.default = series(scssTask, jsTask, watchTask);