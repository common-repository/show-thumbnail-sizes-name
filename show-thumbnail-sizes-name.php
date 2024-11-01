<?php
/**
 * Plugin Name: Thumbnail (Image) Size Names
 * Version: 0.5.4
 * Description: List of image size names of your installation.
 * Author: KGM Servizi
 * Author URI: https://kgmservizi.com
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

/**
 * 
 * Image size names menù and option 
 * 
 */
add_action('admin_menu', 'show_thumbnail_sizes_name_menu');
function show_thumbnail_sizes_name_menu() {
	add_management_page('Image Sizes', 'Image Sizes', 'activate_plugins', 'show-thumbnail-size-name', 'show_thumbnail_sizes_name_function');
}

/**
 * 
 * Show list of image sizes
 */
function show_thumbnail_sizes_name_function() {
	echo '<div style="margin: 50px 25px;">';
    echo '<h1 style="margin: 0 0 25px 0">Image Size Names</h1>';
    echo '<h3>You can disable image sizes with <a href="https://uskgm.it/disable-thumb-image-plugin" target="_blank">this plugin</a>.</h3>';
    echo '<pre>';   
   	foreach ( show_thumbnail_sizes_name_get_image_size() as $name => $_size ) {
   		echo '<div style="margin: 50px 0 0 0">';
   		echo '<h3>' . $name . '</h3>';
		echo 'width => ' . $_size['width'] . '</br>';
		echo 'height => ' . $_size['height'] . '</br>';
		if ($_size['crop'] == 1) {
			echo 'crop => <b>TRUE</b>';
		} else {
			echo 'crop => false';
		}		
		echo '</div>';
	}
    echo '</pre></div>';
}

/**
 * 
 * Function for retrieve all image sizes
 * 
 */
function show_thumbnail_sizes_name_get_image_size() {
	global $_wp_additional_image_sizes;

	$sizes = array();

	foreach ( get_intermediate_image_sizes() as $_size ) {
		if ( in_array( $_size, array('thumbnail', 'medium', 'medium_large', 'large') ) ) {
			$sizes[ $_size ]['width']  = get_option( "{$_size}_size_w" );
			$sizes[ $_size ]['height'] = get_option( "{$_size}_size_h" );
			$sizes[ $_size ]['crop']   = (bool) get_option( "{$_size}_crop" );
		} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
			$sizes[ $_size ] = array(
				'width'  => $_wp_additional_image_sizes[ $_size ]['width'],
				'height' => $_wp_additional_image_sizes[ $_size ]['height'],
				'crop'   => $_wp_additional_image_sizes[ $_size ]['crop'],
			);
		}
	}

	return $sizes;
}
