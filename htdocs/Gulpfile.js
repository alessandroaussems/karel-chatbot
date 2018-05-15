var gulp = require('gulp'),
    concat = require('gulp-concat'),
    sass = require('gulp-sass'),
    sassGlob = require('gulp-sass-glob'),
    livereload = require('gulp-livereload'),
    plumber = require('gulp-plumber'),
    sourcemaps = require('gulp-sourcemaps'),
    notify = require("gulp-notify"),
    autoprefixer = require('gulp-autoprefixer'),
    cache = require('gulp-cache'),
    imagemin = require('gulp-imagemin'),
    cssnano = require('gulp-cssnano'),
    pngquant = require('imagemin-pngquant'),
    rename = require('gulp-rename'),
    path = require('path'),
    uglify = require('gulp-uglify'),
    watch = require('gulp-watch'),
    postcss = require('gulp-postcss'),
    flexibility = require('postcss-flexibility'),
    changed = require('gulp-changed');

var root_path = "resources/assets/";

function errorAlertSass(error) {
    notify.onError({
        "title": "SCSS Error",
        "message": "Waaaaw. Check your tjerminal",
        "sound": "Sosumi",
        "icon": path.join(__dirname, "src/gulp-resources/eddy.jpg")
    })(error); //Error Notification
    console.log(error.toString());//Prints Error to Console
    this.emit("end"); //End function
};
function errorAlertJS(error) {
    notify.onError({
        "title": "JS Error",
        "message": "Waaaaw. Check your tjerminal",
        "sound": "Sosumi",
        "icon": path.join(__dirname, "src/gulp-resources/eddy.jpg")
    })(error); //Error Notification
    console.log(error.toString());//Prints Error to Console
    this.emit("end"); //End function
};

gulp.task('sass', function () {
    return gulp.src(root_path + 'sass/main.scss')
        .pipe(plumber({errorHandler: errorAlertSass}))
        .pipe(sourcemaps.init({loadMaps: true}))
        .pipe(sassGlob())
        .pipe(sass()) // Using gulp-sass
        .pipe(autoprefixer())
        .pipe(postcss([flexibility]))
        .pipe(gulp.dest('public/styling'))
        .pipe(rename({suffix: '.min'}))
        .pipe(cssnano())
        .pipe(sourcemaps.write('../maps'))
        .pipe(gulp.dest('public/styling'))
        .pipe(livereload());
});

gulp.task('scripts', function () {
    return gulp.src(root_path + "js/main.js")
        .pipe(plumber({errorHandler: errorAlertJS}))
        .pipe(sourcemaps.init({loadMaps: true}))
        .pipe(concat('scripts.js'))
        .pipe(gulp.dest('public/js'))
        .pipe(rename({suffix: '.min'}))
        .pipe(uglify())
        .pipe(sourcemaps.write('../maps'))
        .pipe(gulp.dest('public/js'))
        .pipe(livereload());
});

gulp.task('watch', function () {
    livereload.listen();
    gulp.watch(root_path + 'scss/*', ['sass']);
    gulp.watch(root_path + 'js/main.js', ['scripts']);
});

gulp.task('default', ['sass', 'scripts','watch'], function () {});