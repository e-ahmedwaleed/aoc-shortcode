<?php
/*
Plugin Name: bbPress Do Short Codes
Plugin URI: https://github.com/EngAhmedWaleed/AOC-Shortcode/tree/bbpress-do-short-codes
Description: Enables short codes in bbPress Topic and Reply content
Version: 1.0.4
Author: Pippin Williamson (Edited by: Ahmed Waleed)
Author URI: http://pippinsplugins.com
Contributors: mordauk 
*/

function pw_bbp_shortcodes($content, $reply_id)
{

	$reply_author = bbp_get_reply_author_id($reply_id);

	$content = disable_bad_shortcodes($content);

	if (user_can($reply_author, pw_bbp_parse_capability()))
		return do_shortcode($content);

	return $content;
}
add_filter('bbp_get_reply_content', 'pw_bbp_shortcodes', 10, 2);
add_filter('bbp_get_topic_content', 'pw_bbp_shortcodes', 10, 2);

function pw_bbp_parse_capability()
{
	return apply_filters('pw_bbp_parse_shortcodes_cap', 'publish_forums');
}

function disable_bad_shortcodes($content){

	return $content;

}

// https://artiss.blog/2017/07/listing-all-the-currently-available-wordpress-shortcodes/#:~:text=Add%20the%20following%20code%20to,dirty'%20but%20does%20the%20job.&text=add_shortcode(%20'shortcodes'%2C%20'list_shortcodes'%20)%3B
function check_shortcode($shortcode)
{
	// Grab the global array of shortcodes
	global $shortcode_tags;
	$shortcodes = $shortcode_tags;

	foreach ($shortcodes as $code => $function) {
		if ($shortcode == $code)
			return true;
	}

	return false;
}
