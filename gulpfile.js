'use strict';

const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const ts = require('gulp-typescript');

function buildStyles() {
    return gulp.src('static/sass/**/*.sass')
        .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
        .pipe(gulp.dest('dist/css'));
};

function buildTs() {
    return gulp.src('static/ts/**/*.ts')
        .pipe(ts({
            noImplicitAny: true,
            removeComments: true
        }))
        .pipe(gulp.dest('dist/js'));
}

exports.default = function () {
    gulp.watch('static/sass/**/*.sass', buildStyles);
    gulp.watch('static/ts/**/*.ts', buildTs);
}