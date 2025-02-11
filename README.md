# WP Multi Contributors Plugin

## Description
Showing a contributors autors box to a after post content.

## Features
- Allow users to select multiple authors for a post via checkboxes in the post meta box.
- Display the selected authors' names and Gravatars below the post content on single post pages.

## Installation
1. Upload the `wp-multi-contributors` folder to `wp-content/plugins/`.
2. Activate the plugin via the WordPress admin panel.
3. Navigate to "WP Multi Contributors" to configure.

## Configure NPM
Set up NPM to automatically convert SCSS to CSS, minify JavaScript, generate .opt language files, and create a distributable plugin ZIP file.

1. Initial Setup: `Run npm install`.
2. Development Mode: Run `npm run watch` for live reloading.
3. Build for Production: Run `npm run build`.
4. Create Distributable: Run `npm run publish`.

## PHPUnit Test
First, install Composer by running the `composer install` command.

To set up PHPUnit testing, follow these steps:
1. Create a testing database.
2. Configure the database settings in `/tests/wp-config.php`.
3. Place the distributable plugin inside the `/plugins/my-plugin/wordpress/wp-content/plugins/` folder.
4. Finally, run the `composer test` command to execute the defined tests.

## WordPress Coding Standards Test
```
composer phpcs
composer phpcbf
```

## How to Setup

A "Contributors" meta box is available during post creation and editing. This box displays a list of registered authors. You can choose one or more authors by selecting their names. The selected authors will be listed with their Gravatar images after the post content on the single post pa

## Demo
A working demo is available [here](http://www.techza.online/wp-multi-contributors/).

