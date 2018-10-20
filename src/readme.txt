=== Speedmaster ===
Contributors: rkjellberg
Tags: cache, minify css, minify js, minify html, combine css, combine js
Requires at least: 4.9.8
Tested up to: 4.9.8
Requires PHP: 7.0
Stable tag: trunk
License: GPL-3.0
License URI: https://raw.githubusercontent.com/speedmaster-io/speedmaster/master/src/LICENSE

File system cache, CSS, JS, HTML combine & minify, CDN and other optimization tools for WordPress.

== Description ==
This is a Wordpress cache plugin for developers, that uses a JSON-file instead of the normal admin/options-panel to store configuration settings. By doing so, we can load config data before WordPress and mySQL is loaded, which makes a hugh difference on performance. It also makes it easier to set persistent settings for your developing, staging and production environments. Or you can commit the config file to your repo if you're using git. And if something breaks.. you can easily disable the feature by updating the configuration file.

### Features ###
Speedmaster comes with a lot of features that makes your site faster and cleaner:

#### Page cache ####
When a user visits a page on your website, and a cached version of that page is found, the plugin will skip the loading of Wordpress and return the pre-rendered HTML. This can help lower your websites reponse time (also called 'wait' in some speed tests like Pingdom tools) down to 10-50ms. The plugin will cache all GET-requests, but not POST-request or pages that you've manually excluded in the config file.

You can erase/purge cached files whenever you want from the Wordpress toolbar menu or by removing the files in '/wp-content/uploads/speedmaster/cache'

#### Optimizer ####
When enabled, we'll apply filters to the output of all stylesheets and javascripts that are used by the features below:

* Minify HTML
* Minify CSS
* Minify JS
* Combine all CSS files into one
* Combine all JS files into one
* Load JS files in footer
* Disable Embed
* Disable Emojis
* Remove ?ver=* from CSS/JS links

### Configuration ###
A speedmaster.json file will be created at  '/wp-content/uploads/speedmaster/speedmaster.json'. By using JSON for settings instead of the normal WP Dashboard admin panel, we can access config data before WordPress and mySQL is loaded. Cache & optimization settings can only be made by editing this file directly on your host via e.g. FTP or SSH. However, we recommend you to include it in your repo if you\'re using git.

== Installation ==
1. Upload speedmaster to the /wp-content/plugins/ directory
2. Activate the plugin through the ‘Plugins’ menu in WordPress

### Folder permissions ###
This plugin will create some new folders and files on your host when your activate it. Make sure that the '/wp-content/uploads'-directory is writable, or manually create a writeable 'speedmaster'-folder inside of it like: '/wp-content/uploads/speedmaster/'. Open the Speedmaster tab in your Wordpress Dasbhoard to see if all tests passes. If there are any troubles, please press the link besides the info-icon on the test that didn\'t pass.

#### Other changes to your file system: ####
* Your '/wp-config.php' will be updated, with the value of 'WP_CACHE' set to 'true'
* 'advanced-cache.php' will be created in your '/wp-content'-folder.

### Uninstall ###
Follow the steps bellow to remove Speedmaster and all of its files. Steps 1-3 are automatically run when you deactivate the plugin through the Wordpress dashboard.

1. Update 'WP_CACHE' to false in 'wp-config.php'
2. Delete the advanced-cache.php file (/wp-content/advanced-cache.php)
3. Delete the cache directory (/wp-content/uploads/speedmaster/cache/). Or if you don't want to save your configuration, delete the  speedmaster directory.
4. Delete the plugin (/wp-content/plugins/speedmaster/) 