const gulp = require("gulp");
const babel = require("gulp-babel");
const sass = require("gulp-sass");
const minifyCSS = require("gulp-csso");

function css() {
  return gulp
    .src(["./templates/web/sass/main.scss"])
    .pipe(sass())
    .pipe(minifyCSS())
    .pipe(gulp.dest("./templates/web/dist/"));
}

function js() {
  return gulp
    .src(["./templates/web/js/main.js"])
    .pipe(
      babel({
        presets: [["@babel/env", { modules: false }]]
      })
    )
    .pipe(gulp.dest("./templates/web/dist/"));
}

exports.default = function() {
  gulp.watch("templates/web/sass/**/*.scss", css);
  gulp.watch("templates/web/js/main.js", js);
};
