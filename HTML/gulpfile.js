const gulp = require('gulp');
const connect = require('gulp-connect');

// Task to start a development server
gulp.task('serve', function() {
    connect.server({
        root: './',  // Adjust the root directory based on your project structure
        livereload: true,
        port: 3000
    });
});

// Task to watch for changes
gulp.task('watch', function() {
    gulp.watch(['./**/*'], gulp.series('reload'));
});

// Task to reload the server
gulp.task('reload', function(done) {
    connect.reload();
    done();
});

// Default task
gulp.task('default', gulp.series('serve', 'watch'));
