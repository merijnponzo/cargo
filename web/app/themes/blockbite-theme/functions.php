<?php

/** 
 * load essential theme lib files
 */
$theme_files = [
	'site/post-types.php',
	'site/fields.php',
	'site/cleanup.php',
	'site/assets.php',
	'blocks/custom-nav/index.php',
	'blocks/custom-diensten-list/index.php',
	'blocks/custom-logo/index.php',
	'blocks/custom-year/index.php'
];

foreach ($theme_files as $file) {

	if (!$filepath = locate_template($file)) {
		trigger_error(sprintf(__('Error locating %s for inclusion'), $file), E_USER_ERROR);
	}
	include_once $filepath;
}

/* register nav */
function register_menus()
{
	register_nav_menu('main-menu', __('Main Menu'));
}
add_action('init', 'register_menus');


/* remove default block patterns */
function disable_default_block_patterns()
{
	remove_theme_support('core-block-patterns');
}
add_action('after_setup_theme', 'disable_default_block_patterns');

/* load default theme assets */

use Blockbite\Assets\siteAssets;
use Blockbite\Cleanup\siteCleanup;
use Blockbite\Fields\siteFields;
use Blockbite\PostTypes\sitePostTypes;

/* cleanup */

$cleanup = new siteCleanup();
$cleanup->init();

/* load assets */
$assets = new siteAssets();
/* load fields */
$fields = new siteFields();
/* load custom post types */
$post_types = new sitePostTypes();
