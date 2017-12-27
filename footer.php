<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package codeGreen
 */

?>

	</div><!-- #content -->
</div><!-- #page -->

<footer id="colophon" class="site-footer">
    <div id="colophon-content" class="site-footer-content center-block">
        <div class="site-info">
            <?php
                echo apply_filters( 
                    'codegreen_custom_footer', 
                    /* translators: Copyright symbol, 1: Year, 2: Blog name, Y: date format for year */
                    sprintf( __( '&copy; %d %s', 'codegreen' ),  date( __( 'Y', 'codegreen') ), get_bloginfo( 'title' ))
                );
            ?>
        </div>
    </div>
</footer><!-- #colophon -->

<?php wp_footer(); ?>

</body>
</html>