<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package codeGreen
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area sidebar-collapsed col-md-4">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside><!-- #secondary -->