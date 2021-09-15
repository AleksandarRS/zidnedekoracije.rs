# LibraFire magicwalls Theme

Tags: **translation-ready, custom-background, theme-options, custom-menu, post-formats, threaded-comments**

**Requires at least: 4.0**
**Tested up to: 5.0.2**
**Stable tag: 1.0.0**
**License: GPLv2 or later**
**License URI: http://www.gnu.org/licenses/gpl-2.0.html**

# Description

Custom theme which uses bootstrap framework and a couple of predefined sample codes.

# Installation
	
1. In your admin panel, go to Appearance > Themes and click the Add New button.
2. Click Upload and Choose File, then select the theme's .zip file. Click Install Now.
3. Click Activate to use your new theme right away.

# Changelog

    - 1.0.1 = Removed unnecessary files from root - 21.12.2018
    - 1.0.0 = Initial release - 325 BC

# Initial theme setup (starting a new project)

    1. Remove .git folder from theme root

    2. Before installing node_module update gulp CLI with command: [npm install -g gulp-cli]

    3. install node modules: [npm install]

    4. Before start Gulp edit Gulpfile.js (set variables project - theme name, text_domain - for translation, packageName - for translation description).

    5. Start watching files: [gulp]

# Deploy

    Run [npm run build]

#Theme functions
- magicwalls_posted_on();
    > Example: Posted on April 11, 2019 by 
- magicwalls_entry_footer();
    > Example: Posted in Uncategorized Tagged test Leave a comment
- magicwalls_post_navigation();
    > Example: 1 2 3 … 11 
- magicwalls_share_links();
    > Example: fb, tw, ln, pinterest
- magicwalls_archive_title();
    > <h1 class='page-title'>Title</h1>

#ACF google API key
- The constant 'ACF_GOOGLE_API_KEY' should be defined in wp-config.php
    > Example: define( 'ACF_GOOGLE_API_KEY', 'AIzaSyBQilzeY4HHSm9_2Gfml01G5D8shVjelAQ' );