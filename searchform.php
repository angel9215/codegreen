<?php
/**
 * Template for displaying a custom search form
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package codeGreen
 */


//To do: A
//Add form generator
//Echo form based on local variable
?>

<form method="get" class="search-form" action="<?php echo home_url( '/' ) ?>">
    <label>
        <input type="search" class="search-field" placeholder="<?php _e( 'Search&hellip;', 'codegreen' ) ?>" value="<?php the_search_query() ?>" name="s" />
    </label>
    <input type="submit" class="search-submit" value="<?php _e( 'Search', 'codegreen' ) ?>" />
</form>