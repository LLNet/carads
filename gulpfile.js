let gulp = require('gulp');
let zip = require('gulp-zip');
let pckg = require('./package.json');
let replace = require('gulp-replace-task');
let beep = require('beepbeep');
let rename = require("gulp-rename");
const gutil = require('gutil');
const ftp = require('vinyl-ftp');
const sftp = require('gulp-sftp-up4');

let user = "indexedplugins";
let password = "L06WOj0KlxXh39fx";


function getFtpConnection(remoteLocation) {

    conn = sftp({
        host: 'shared02.indexed.dk',
        user: user,
        pass: password,
        port: '22',
        remotePath: remoteLocation,
    });

    return conn;
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
        .pipe(rename(function (file) {
            file.dirname = pckg.name + '/' + file.dirname;
        }))
        .pipe(replace(pattern_options))

        .pipe(zip(pckg.name + '-' + pckg.version + '.zip'))
        .pipe(gulp.dest('./../'));

});

/**
 * UPLOAD ZIP
 */
let localFiles = './../' + pckg.name + '-' + pckg.version + '.zip';
const remoteLocation = './httpdocs/files/' + pckg.name + '-' + pckg.version + '.zip';
gulp.task('upload', function () {
    let connection = getFtpConnection(remoteLocation);

    return gulp.src(localFiles, {base: '.', buffer: false})
        .pipe(connection);
});


/**
 * UPLOAD JSON
 */
let localReleaseFile = ['./release.json'];
const remoteReleaseLocation = './httpdocs/json/';
gulp.task('upload-release-json', function () {
    let connection = getFtpConnection(remoteReleaseLocation);

    return gulp.src(localReleaseFile, {base: '.', buffer: false})
        // .pipe(replace(pattern_options))
        .pipe(rename(pckg.name + '.json'))
        .pipe(connection)
        .on('end', function () {
            gutil.log('Done !');
            beep();
        })
})


/**
 * RELEASE SCRIPT SERIES
 */
gulp.task("release", gulp.series("zip", "upload", "upload-release-json"), function (done) {
    done();
});