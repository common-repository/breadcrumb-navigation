<?php
/*
Plugin Name: Breadcrumb Navigation
Plugin URI: http://wordpress.org/
Description: Breadcrumb-style navigation.  Shows current viewing post or page, search results, category, and archives.
Version: 0.8.81
Author: Mark A. Shields
Author URI: http://markashields.com/

Copyright (c) 2005 Mark A. Shields

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/
function get_breadcrumb($rootName = "Home", $sr = true,  $prefix = "&raquo;", $showOnSingle = true, $sep = "&gt;", $divid = "breadcrumb", $usedis = false, $dividSingle = "breadcrumb_single", $uselfsp = false) {
	global $posts, $author, $s;
	$m_gb_count = 0;
	while (have_posts()) : the_post();
		$m_gb_count++;
		if ($m_gb_count == 1) : // Only output breadcrumb *once*!

			if (!is_home()) { //main output
			
			echo "<div id='";
			if (is_single() && $usedis) {
				echo "$dividSingle'>";
			} else {
				echo "$divid'>";
			}
				echo $prefix;
				?> <a href="<?php _e(get_settings('home')); ?>" title="Go <?php echo $rootName; ?>!"><?php echo $rootName; ?></a> <?php /*if (!$showOnSingle) {*/ echo $sep; //} ?> <?php			
				if (is_single() && $showOnSingle == true) {
						?><?php the_category(', '); ?> <?php echo $sep; ?> <span id="post-<?php the_ID(); ?>"><?php
						if ($uselfsp) { ?><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>"><em><?php single_post_title(); ?></em></a><?php
						} else if (!$uselfsp) { ?><em><?php single_post_title(); ?></em><?php } ?>
						</span><?php
				} else if ($author) {
					_e("Posts by"); echo " <em>"; the_author(); echo "</em>";
				} else if (is_page()) {
					_e("Page: "); echo "<em>" . single_post_title() . "</em>";
				} else if ($s) {
					_e("Search Results for"); ?> <em><?php echo $s ?></em><?php
				} else if (is_archive()) {
					_e("Archive for");
					if (is_day()) {
						?> <em><?php the_time('F'); ?>, <?php the_time('Y'); ?> <?php echo $sep ?> <?php the_time('jS'); ?></em><?php
					} else if (is_month()) {
						?> <em><?php the_time('F'); ?>, <?php the_time('Y'); ?></em><?php
					} else if (is_year()) {
						?> <em><?php the_time('Y'); ?></em><?php
					} else if (is_category()) {
						_e(' the '); _e('\''); single_cat_title(); _e('\''); _e(' Category');
					}
				}
			echo "</div>";
			
			} else if (is_home() && $sr) {  // if all else fails to match, at least display something (if $sr is set)
				echo "<div id='$divid' style='display:none'>";
				echo $prefix;
				?> <a href="<?php _e(get_settings('home')); ?>" title="Go <?php echo $rootName; ?>!"><?php echo $rootName; ?></a> <?php
				echo "</div>";
			}

		endif;
	endwhile;
	rewind_posts();
}
?>
