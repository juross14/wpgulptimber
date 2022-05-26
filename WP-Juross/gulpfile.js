const { src, dest, watch, series} = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const postcss = require('gulp-postcss');
const cssnano = require('cssnano');
const minify = require('gulp-minify');
const browsersync = require('browser-sync').create();

// Sass Task
function sassTask() {
    return src('preproc/scss/style.scss',{sourcemaps:true})
        .pipe(sass())
        .pipe(postcss([cssnano()]))
        .pipe(dest('dist',{sourcemaps:'.'}));
}

// JavaScript Task
function jsTask(){
    return src('preproc/js/script.js', { sourcemaps: true })
      .pipe(minify())
      .pipe(dest('dist', { sourcemaps: '.' }));
}


 // Browser Reload 
function browsersyncReload(cb){
    browsersync.reload();
    cb();
}

// Watch Task
function watchTask(){
    watch(['preproc/scss/**/*.scss', 'preproc/js/**/*.js'], series(sassTask, jsTask, browsersyncReload));
}

// Default Gulp task
exports.default = series(
    sassTask,
    jsTask,
    watchTask
);