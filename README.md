# Speedmaster dev
[![Build Status](https://travis-ci.org/speedmaster-io/speedmaster.svg?branch=master)](https://travis-ci.org/speedmaster-io/speedmaster)
[![Maintainability](https://api.codeclimate.com/v1/badges/67db2b4f48cf95db61bf/maintainability)](https://codeclimate.com/github/speedmaster-io/speedmaster/maintainability)

This repository is for development use only. If you're looking for a version of Speedmaster that you can install on your website, please download the latest version directly from the [Wordpress plugin directory](https://wordpress.org/plugins/speedmaster/).

## Getting started

### Clone this repository
```git clone git@github.com:speedmaster-io/speedmaster.git```

### Run the development environment
```cd``` into this directory and run ```docker-compose up```

*You'll need Docker installed on your system to run a full development server. However, if that's not your thing, just copy & paste all files from ```src/``` in this repo to ```<website-path>/wp-content/plugins/speedmaster/``` on your development server. When your done, copy your changes back to this repo and create a pull request.*

### Install Wordpress
When docker-compose is up and running, visit [https://localhost:8080](https://localhost:8080) in your browser and follow the Wordpress tutorial to install your site and create an admin user.

## Features
- Cache pages as HTML and return pre-rendered static pages for visitors.
- Cache on everything except POST-requests.
- Combine all CSS files to one and then minify it.
- Combine all JS files to one and then minify it.
- Minify HTML without breaking inline Javascript.
- Auto replace image, stylesheet and javascript URLs with your CDN url.
- Development friendly configuration with a JSON file (```speedmaster.json```).

## The ```speedmaster.json``` configuration file
A ```speedmaster.json``` file must be created in your ```SPEEDMASTER_DATA_DIR```-folder, which defaults to ```ABSPATH . '/wp-content/uploads/speedmaster/```. By using JSON instead of the normal WP Dashboard admin panel, we can access config data before WordPress and mySQL is loaded, which saves us a lot of time.

```json
{
  "cache": {
    "enabled": false,
    "exclude": []
  },
  "optimizer": {
    "enabled": true,

    "minify_html": false,
    "remove_ver": true,
    "local_url": "http://127.0.0.1",
    "disable_emojis": true,
    "disable_embed": true,

    "minify_css": true,
    "combine_css": false,
    "exclude_css": ["bootstrap", "font-awesome"],

    "minify_js": true,
    "combine_js": false,
    "exclude_js": [],
    "js_in_footer": false
  },
  "cdn": {
    "enabled": false,
    "hosts": ["http://localhost:8080"],
    "url": "http://cdn.mywebsite.com/",
    "include": [],
    "exclude": []
  }
}
```

#### Todo
- https://deliciousbrains.com/deploying-wordpress-plugins-travis/

## How to

### Create a module
You can use Wordpress filters to manipulate HTML, CSS and JS content in your module.

```php
// Minify HTML
add_filter('speedmaster_buffer', function( $buffer ) {
  return my_custom_minifier($buffer);
});

// Minify CSS
add_filter('speedmaster_css', function( $css ) {
  return my_custom_minifier($css);
});
```

#### All filters
- speedmaster_buffer
- speemdaster_css
- speemdaster_js

### Read config values
You can use the global variable ```$smconfig``` to read configuration variables

```php
add_action('wp_footer', function() {
  global $smconfig;

  if ($smconfig->get('optimizer', 'disable_embed')) {
    // Disable the wp-embed.min.js file
    wp_dequeue_script( 'wp-embed' );
  }
});
```
