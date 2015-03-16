module.exports = function ( grunt ) {
    // Do grunt-related things in here

    // Project configuration.
    //noinspection JSUnresolvedFunction
    grunt.initConfig( {
        pkg: grunt.file.readJSON( 'package.json' ),


        /**
         * LESS and CSS tasks
         */
        less: {
            dev: {
                options: {
                    compile: true,
//					paths: ["src/style/modules"],

                },
                files: {
                    "dist/runalyze.css": [
                        "src/style/runalyze-style.less"
                    ]
                }
            },
            dist: {
                options: {
                    compile: true,
                    compress: true,
                    cleancss: true
                },
                files: {
                    "dist/runalyze.css": [
                        "src/style/runalyze-style.less"
                    ]
                }

            }
        },

        /**
         *  JS-Tasks
         */
        uglify: {

            options: {
                banner: '/*! <%= pkg.description %> - v<%= grunt.template.today("yyyy.mm.dd") %> - ' +
                '<%= grunt.template.today("yyyy-mm-dd HH:MM") %> */',
                compress: {
                    properties: true,
                    dead_code: true,
                    booleans: true,
                    loops: true,
                    hoist_funs: true
                }
            },

            main: {
                files: {
                    'dist/runalyze.min.js': [
                        'src/lib/jquery-2.1.0.min.js',
                        'src/lib/jquery.form.js',
                        'src/lib/jquery.metadata.js',
                        'src/lib/jquery.tablesorter-2.18.4.js',
                        'src/lib/jquery.tablesorter-2.18.4.pager.js',
                        'src/lib/bootstrap-tooltip.js',

                        'src/lib/fineuploader-3.5.0.min.js',

                        'src/lib/jquery.datepicker.js',

                        'src/lib/jquery.chosen.min.js',

                        'src/js/runalyze.lib.js',
                        'src/js/runalyze.lib.plot.js',
                        'src/js/runalyze.lib.plot.options.js',
                        'src/js/runalyze.lib.plot.saver.js',
                        'src/js/runalyze.lib.plot.events.js',
                        'src/js/runalyze.lib.tablesorter.js',
                        'src/js/runalyze.lib.log.js',
                        'src/js/runalyze.lib.options.js',
                        'src/js/runalyze.lib.config.js',
                        'src/js/runalyze.lib.overlay.js',
                        'src/js/runalyze.lib.panels.js',
                        'src/js/runalyze.lib.databrowser.js',
                        'src/js/runalyze.lib.statistics.js',
                        'src/js/runalyze.lib.training.js',
                        'src/js/runalyze.lib.feature.js',

                        'src/lib/flot-0.8.3/base64.js',

                        'src/lib/flot-0.8.3/jquery.flot.min.js',
                        'src/lib/flot-0.8.3/jquery.flot.resize.min.js',
                        'src/lib/flot-0.8.3/jquery.flot.selection.js',
                        'src/lib/flot-0.8.3/jquery.flot.crosshair.js',
                        'src/lib/flot-0.8.3/jquery.flot.navigate.min.js',
                        'src/lib/flot-0.8.3/jquery.flot.stack.min.js',
                        //'src/lib/flot-0.8.3/jquery.flot.text.js',
                        'src/lib/flot-0.8.3/jquery.flot.textLegend.js',
                        'src/lib/flot-0.8.3/jquery.flot.orderBars.js',
                        'src/lib/flot-0.8.3/jquery.flot.hiddengraphs.js',
                        'src/lib/flot-0.8.3/jquery.flot.canvas.js',
                        'src/lib/flot-0.8.3/jquery.flot.time.min.js',
                        'src/lib/flot-0.8.3/jquery.flot.curvedLines.js',

                        'src/lib/leaflet/leaflet.js',
                        'src/lib/leaflet/runalyze.leaflet.js',
                        'src/lib/leaflet/runalyze.leaflet.layers.js',
                        'src/lib/leaflet/runalyze.leaflet.routes.js',

                        'src/lib/fontIconPicker-2.0.0/jquery.fonticonpicker.js',
                    ]
                }
            }
        },


        /**
         *  Concat JS Files
         */

        concat: {
            scripts: {
                files: {
                    'dist/js/app.js': ['src/js/_app.js', 'src/js/app.*.js'],
                    'dist/js/modules.js': ['src/js/modules/*.js'],
                    'dist/js/models.js': ['src/js/models/*.js'],
                    'dist/js/views.js': ['src/js/views/*.js'],
                    'dist/js/controllers.js': ['src/js/controllers/*.js'],
                    'dist/js/routes.js': ['src/js/routes/*.js']
                }
            }
        },
        /**
         *  Watch tasks
         */
        watch: {
            options: {
                livereload: true
            },
            styles: {
                files: ['src/style/**/*.less'],
                tasks: ['less:dev'],
                options: {
                    spawn: true
                }
            },
            jsuncompressed: {
                files: ['src/js/**/*.js'],
                tasks: ['concat:scripts']
            }
        }
    } );

    // Load modules
    //grunt.loadNpmTasks( 'grunt-contrib-copy' );
    grunt.loadNpmTasks( 'grunt-contrib-less' );
    grunt.loadNpmTasks( 'grunt-contrib-watch' );
    grunt.loadNpmTasks( 'grunt-contrib-concat' );
    grunt.loadNpmTasks( 'grunt-contrib-uglify' );


    // define task(s).
    grunt.registerTask( 'default', ['less:dev', 'concat'] );
};
