<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package codeGreen
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php wp_head(); ?>
</head>

<body <?php body_class( /*( is_singular() ? 'singular' : '' )*/ ); ?>>
<nav id="site-navigation" class="main-navigation clearfix">
    <div id="site-navigation-content" class="main-navigation-content center-block">
        <?php /*<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'codegreen' ); ?> </button>*/ ?>
        <div id="primary-menu" class="primary-menu menu_container wp-menu wp-horizontal-menu wp-css-menu">
            <?php
                wp_nav_menu( array(
                    'theme_location'  => 'menu-1',
                    'menu_class'      => 'menu-root',
                    'container'       => '',
                    'fallback_cb'     => 'codegreen_fallback_menu'
                ) );
            ?>

            <div id="menu-search-button" class="menu-search-button search-button menu-item">
                <div class="menu-search-form" style="display:none;">
                    <?php get_search_form(); ?>
                </div>
                <a href="<?php echo home_url('/search-page/') ?>" class="menu-search-button-link"><span class="menu-search-button-icon glyphicon glyphicon-search"></span></a>
            </div>
        </div>
    </div>
</nav><!-- #site-navigation -->

<div id="page" class="site center-block">
	<header id="masthead" class="site-header clearfix">
		<div class="site-branding">
			<?php the_custom_logo(); ?>
            <div class="site-branding-text">
                <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-title-link" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                <?php
                $description = get_bloginfo( 'description', 'display' );
                if ( $description || is_customize_preview() ) : ?>
                <p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
                <?php
                endif; ?>
            </div>
		</div>
	</header><!-- #masthead -->

	<div id="content" class="site-content container-fluid clearfix">
