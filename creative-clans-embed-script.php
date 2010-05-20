<?php
/*
Plugin Name: Creative Clans Embed Script
Plugin URI: http://www.creativeclans.nl
Description: Gives the possibility to add scripts to the end of the 'content' of any page or post. 
Version: 1.0
Author: Guido Tonnaer
Author URI: http://www.creativeclans.nl

Copyright 2010 Guido Tonnaer

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

/**
 * Determine the location.
 */
$ccembedscriptpluginpath = WP_CONTENT_URL.'/plugins/'.plugin_basename(dirname(__FILE__)).'/';

/**
 * Hook the_content to output the scripts added to the page or post.
 */
add_filter('the_content', 'ccembedscript_display_hook');
add_filter('the_excerpt', 'ccembedscript_display_hook');
	
/**
 * Loop through the settings and check whether ccembedscript should be outputted.
 */
function ccembedscript_display_hook($content='') {
	global $post;
  return $content . get_post_meta($post->ID, '_ccembedscripttext', true);
}

/**
 * Displays a text that allows users to insert the scripts for the post or page
 */
function ccembedscript_meta() {
	global $post;
	?>
	<label for="ccembedscripttext"><?php _e('Script to be inserted','ccembedscript') ?></label><br />
  <textarea id="ccembedscripttext" name="ccembedscripttext" /><?php echo get_post_meta($post->ID,'_ccembedscripttext',true); ?></textarea>
	<?php
}

/**
 * Add the checkbox defined above to post and page edit screens.
 */
function ccembedscript_meta_box() {
	add_meta_box('ccembedscript','Creative Clans Embed Script','ccembedscript_meta','post','side');
	add_meta_box('ccembedscript','Creative Clans Embed Script','ccembedscript_meta','page','side');
}
add_action('admin_menu', 'ccembedscript_meta_box');

/**
 * If the post is inserted, save the script.
 */
function ccembedscript_insert_post($pID) {
  $text = (isset($_POST['ccembedscripttext'])) ? $_POST['ccembedscripttext'] : '';
  update_post_meta($pID, '_ccembedscripttext', $text);
}
add_action('wp_insert_post', 'ccembedscript_insert_post');

?>