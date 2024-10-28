module.exports = function (grunt) {

    var currentdate = new Date();
    var datetime = currentdate.getDate() + "/"
        + (currentdate.getMonth() + 1) + "/"
        + currentdate.getFullYear() + " @ "
        + currentdate.getHours() + ":"
        + currentdate.getMinutes() + ":"
        + currentdate.getSeconds();

    grunt.initConfig({
        concat: {
            options: {
                separator: '\n',
                sourceMap: true,
                banner: "/*Processed by Sakil Bharath on " + datetime + "*/\n"
            },
            admin_js: {
                src: [
                    '../js/admin/*.js',
                ],
                dest: 'dist/admin.cc.js'
            },
            index_js: {
                src: [
                    '../js/index/*.js',
                ],
                dest: 'dist/index.cc.js'
            }
        },
        cssmin: {
            options: {
                mergeIntoShorthands: false,
                roundingPrecision: -1
            },
            target: {
                files: {
                    '../../htdocs/css/admin.min.css': ['dist/admin.cc.css'],
                    '../../htdocs/css/index.min.css': ['dist/index.cc.css'],
                }
            }
        },
        uglify: {
            minify: {
                options: {
                    sourceMap: true,
                },
                files: {
                    '../../htdocs/js/admin.min.js': ['dist/admin.cc.js'],
                    '../../htdocs/js/index.min.js': ['dist/index.cc.js'],
                }
            }
        },
        // copy: {
        //     jquery: {
        //         files: [
        //             {
        //                 expand: true, 
        //                 flatten: true,
        //                 filter: 'isFile',
        //                 src: ['bower_components/jquery/dist/*'], 
        //                 dest: '../../htdocs/js/jquery/'
        //             },
        //         ],
        //     },
        // },
        obfuscator: {
            options: {
                banner: '// obfuscated with grunt-contrib-obfuscator.\n',
                debugProtection: true,
                debugProtectionInterval: true,
                // domainLock: ['sheeinfo.com']
            },
            task1: {
                options: {
                },
                files: {
                    '../../htdocs/js/admin.o.js': [
                        'dist/admin.cc.js',
                    ]
                }
            }
        },
        watch: {
            css: {
                files: [
                    '../css/**/*.css',
                ],
                tasks: ['cssmin'],
                options: {
                    spawn: false,
                },
            },
            js: {
                files: [
                    '../js/**/*.js'
                ],
                tasks: ['uglify', 'obfuscator'],
                options: {
                    spawn: false,
                },
            },
        },
    });

    grunt.loadNpmTasks('grunt-contrib-obfuscator');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.registerTask('default', ['copy', 'concat', 'cssmin', 'uglify', 'obfuscator', 'watch']);
};
