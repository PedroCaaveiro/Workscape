import { src, dest, watch, series } from 'gulp'
import gulpSass from 'gulp-dart-sass'
import terser from 'gulp-terser'

// No es necesario pasar 'dartSass' en este caso
const sass = gulpSass

const paths = {
    scss: 'src/scss/**/*.scss',
    js: 'src/js/**/*.js'
}

export function css(done) {
    src(paths.scss, { sourcemaps: true })
        .pipe(sass({ outputStyle: 'compressed' }).on('error', sass.logError)) // No pasa dartSass
        .pipe(dest('./public/build/css', { sourcemaps: '.' }))
    done()
}

export function js(done) {
    src(paths.js)
        .pipe(terser())
        .pipe(dest('./public/build/js'))
    done()
}

export function dev() {
    watch(paths.scss, css)
    watch(paths.js, js)
}

export default series(js, css, dev)
