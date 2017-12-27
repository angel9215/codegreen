<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package codeGreen
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function codegreen_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
    // Adds a class of singular to singular pages.
	if ( is_singular() ) {
        $classes[] = 'singular';
	} else {
        $classes[] = 'hfeed';
    }

	return $classes;
}
add_filter( 'body_class', 'codegreen_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function codegreen_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'codegreen_pingback_header' );


/**
 * Output a menu similar to 'wp_nav_menu' using 'wp_page_menu'.
 * To be used as 'fallback_cb' for 'wp_nav_menu'.
 */
function codegreen_fallback_menu( $args ) {
    if ( !isset( $args['echo'] ) ) {
        $printMenu = true;
    } else {
        $printMenu = $args['echo'];
    }
    
    if ( empty( $args['container'] ) ) {
        $args['container'] = 'ul';
        
        if ( empty( $args['before'] ) && empty( $args['after'] ) ) {
            $args['before'] = '';
            $args['after'] = '';
        }
    } else {
        if ( empty( $args['before'] ) &&  empty( $args['after'] ) ) {
            $args['before'] = '<ul' . ( empty( $args['menu_id'] ) ? '' : ' id="' . $args['menu_id'] . '"' ) . 
                                ( empty( $args['menu_class'] ) ? '' : ' class="' . $args['menu_class'] . '"' ) . '>';
            $args['after'] = '</ul>';
        }
        
        if ( empty( $args['container_id'] ) ) {
            unset( $args['menu_id'] );
        } else {
            $args['menu_id'] = $args['container_id'];
        }
        
        if ( empty( $args['container_class'] ) ) {
            unset( $args['menu_class'] );
        } else {
            $args['menu_class'] = $args['container_class'];
        }
    }
    
    $args['echo'] = false;
    
    $menu = codegreen_convert_page_menu( wp_page_menu( $args ) );
    
    if ( $printMenu ) {
        echo $menu;
    } else {
        return $menu;
    }
}

/**
 * Helper function for 'codegreen_fallback_menu'.
 */
function codegreen_convert_page_menu( $menu ) {
    $menu = preg_replace( '/(<ul.*?class=)[\'"](.*?)children(.*?)([\'"])/', '$1"$2sub-menu$3"', $menu );
    
    preg_match_all( '/<li.*?>/', $menu, $items );
    
    $items = $items[0];
    
    foreach ($items as $item) {
        $modifiedItem = $item;
        
        $class = ( preg_match( '/class="(.*?)"/', $item, $classContent ) ? $classContent[1] : '' );
        
        $modifiedClass = strtr( 
            $class, 
            array (
               'page_item' => 'page_item menu-item menu-item-type-post_type menu-item-object-page',
               'page_item_has_children' => 'menu-item-has-children',
               'current_page_item' => 'current_page_item current-menu-item',
               'current_page_parent' => 'current_page_parent current-menu-parent',
               'current_page_ancestor' => 'current_page_ancestor current-menu-ancestor'
            )
        );
        
        $modifiedItem = strtr( $modifiedItem, array( $class => $modifiedClass ) );
        
        $menu = strtr( $menu, array( $item => $modifiedItem ) );
    }
    
    echo $menu;
}

/**
 * Generate numbered navigation
 */
function codegreen_numbered_navigation() {
    /* translators: %1$s: navigation icons */
    //sprintf( esc_html__( '%1$sPrevious', 'codegreen' ), '<span class="navigation-previous-page-icon glyphicon glyphicon-menu-left"></span>' )
    //sprintf( esc_html__( 'Next%1$s', 'codegreen' ), '<span class="navigation-next-page-icon glyphicon glyphicon-menu-right"></span>' )
    $navLinks = paginate_links( array( 
        'end_size'  => 2,
        'mid_size'  => 3,
        'prev_text' => '<span class="navigation-previous-page-icon glyphicon glyphicon-menu-left"></span>',
        'next_text' => '<span class="navigation-next-page-icon glyphicon glyphicon-menu-right"></span>'
    ) );
    
    if ( $navLinks != '' ) :
    ?>
        <nav class="navigation wp-pagination">
           <div class="nav-links">
            <?php
                echo $navLinks;
            ?>
            </div>
        </nav>
    <?php
    endif;
}

/**
 * Generate post navigation
 */
function codegreen_post_navigation() {
    the_post_navigation(array(
        'prev_text'          => '<span class="navigation-previous-page-icon glyphicon glyphicon-menu-left"></span>%title',
        'next_text'          => '%title<span class="navigation-next-page-icon glyphicon glyphicon-menu-right"></span>',
        'screen_reader_text' => ' '
    ));
}

/**
 * Generate read more message
 */
function codegreen_read_more($title) {
    return sprintf(
        wp_kses(
            /* translators: %s: Name of current post. Only visible to screen readers */
            __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'codegreen' ),
            array(
                'span' => array(
                    'class' => array(),
                ),
            )
        ),
        $title
    );
}