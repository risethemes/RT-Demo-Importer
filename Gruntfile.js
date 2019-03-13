module.exports = function(grunt) {

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        makepot: {
            
            options: {
                potFilename: 'rt-demo-importer.pot',                    
                domainPath: 'languages/',
                type: 'wp-plugin'
            },
            dist: {
                options: {
                    potFilename: 'rt-demo-importer.pot',
                    exclude: [
                        'vendor/.*'
                    ]
                }
            }
        },
        // Add Textdomain.
        addtextdomain: {
            options: {
                textdomain: 'rt-demo-importer',
                updateDomains: ['wordpress-importer']
            },
            target: {
                files: {
                    src: [
                        '**/*.php',         // Include all files
                        '!node_modules/**', // Exclude node_modules/
                        '!vendor/**',        // Exclude vendor/
                        '!seperate_url_demo_importer/**'        // Exclude vendor/
                    ]
                }
            }
        },

        // Check textdomain errors.
        checktextdomain: {
            options: {
                text_domain: 'rt-demo-importer',
                keywords: [
                    '__:1,2d',
                    '_e:1,2d',
                    '_x:1,2c,3d',
                    'esc_html__:1,2d',
                    'esc_html_e:1,2d',
                    'esc_html_x:1,2c,3d',
                    'esc_attr__:1,2d',
                    'esc_attr_e:1,2d',
                    'esc_attr_x:1,2c,3d',
                    '_ex:1,2c,3d',
                    '_n:1,2,4d',
                    '_nx:1,2,4c,5d',
                    '_n_noop:1,2,3d',
                    '_nx_noop:1,2,3c,4d'
                ]
            },
            files: {
                src: [
                    '**/*.php',         // Include all files
                    '!node_modules/**', // Exclude node_modules/
                    '!vendor/**'        // Exclude vendor/
                ],
                expand: true
            }
        },

        // PHP Code Sniffer.
        phpcs: {
            options: {
                bin: 'vendor/bin/phpcs',
                standard: './phpcs.ruleset.xml'
            },
            dist: {
                src:  [
                    '**/*.php',                                 // Include all files
                    '!node_modules/**',                         // Exclude node_modules/
                    '!vendor/**',                               // Exclude vendor/
                    '!includes/importers/wordpress-importer/**' // Exclude wordpress-importer/
                ]
            }
        }
    });
grunt.loadNpmTasks( 'grunt-phpcs' );
grunt.loadNpmTasks( 'grunt-phpcs' );
grunt.loadNpmTasks( 'grunt-wp-i18n' );
grunt.loadNpmTasks( 'grunt-checktextdomain' );

grunt.registerTask('default', ['checktextdomain','makepot'] );



}    
