
let gulp = require('gulp');
let zip = require('gulp-zip');
let pckg = require('./package.json');
let replace = require('gulp-replace-task');
let beep = require('beepbeep');
let rename = require("gulp-rename");
const gutil = require('gutil');
const ftp = require('vinyl-ftp');

let user = "plugins";
let password = "?Mm6uj58";

function getFtpConnection() {
    return ftp.create({
        host: 'shared02.indexed.dk',
        port: 21,
        user: user,
        password: password,
        log: gutil.log
    });
}

const pattern_options = {
    patterns: [
        {
            match: /PLUGIN_VERSIONING/,
            replacement: pckg.version
        },
        {
            match: /PLUGIN_TITLE/,
            replacement: pckg.title
        },
        {
            match: /PLUGIN_NAME/,
            replacement: pckg.name
        },
        {
            match: /PLUGIN_DESCRIPTION/,
            replacement: pckg.description
        },
    ]
}

/**
 * ZIP
 */
gulp.task('zip', function () {

    return gulp
        .src([
            './**/*',
            '!./{node_modules,node_modules/**/*}',
            '!./assets/app.js',
            '!./assets/app.css',
            '!./src/scss/**/*',
            '!./src/js/**/*',
            '!./gulpfile.js',
            '!./package.json',
            '!./package-lock.json',
            '!./webpack.mix.js',
            '!./mix-manifest.json',
            '!./.gitignore',
            '!./readme.md',
            '!./composer.json',
            '!./release.json',
            '!./composer.lock',
            '!./yarn.lock',
            '!./.git/**/*',
            '!./logs/**/*',
        ], {base: '.'})
        .pipe(rename(function(file) {
            file.dirname = pckg.name + '/' + file.dirname;
        }))
        .pipe(replace(pattern_options))

        .pipe(zip(pckg.name + '-' + pckg.version +  '.zip'))
        .pipe(gulp.dest('./../'));

});

/**
 * UPLOAD ZIP
 */
let localFiles = ['./../' + pckg.name + '-' + pckg.version + '.zip'];
const remoteLocation = '/files/'+ pckg.name + '-' + pckg.version + '.zip';
gulp.task('upload', function () {
    let connection = getFtpConnection();
    return gulp.src(localFiles, {base: '.', buffer: false})
        .pipe(connection.newer(remoteLocation))
        .pipe(connection.dest(remoteLocation))
        .on('end', function() {
            gutil.log('Done !');
            beep();
        })})


/**
 * UPLOAD JSON
 */
let localReleaseFile = ['./release.json'];
const remoteReleaseLocation = '/json/';
gulp.task('upload-release-json', function () {
    let connection = getFtpConnection();
    return gulp.src(localReleaseFile, {base: '.', buffer: false})
        // .pipe(replace(pattern_options))
        .pipe(rename(pckg.name + '.json'))

        .pipe(connection.newer(remoteReleaseLocation))
        .pipe(connection.dest(remoteReleaseLocation))
        .on('end', function() {
            gutil.log('Done !');
            beep();
        })})


/**
 * RELEASE SCRIPT SERIES
 */
gulp.task("release", gulp.series("zip", "upload", "upload-release-json"), function (done) {
    done();
});