<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package codeGreen
 */

get_header(); ?>

	<section id="primary" class="content-area col-md-8">
		<main id="main" class="site-main">

		<?php
		if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title"><?php
					/* translators: %s: search query. */
					echo esc_html__( 'Search Results', 'codegreen' );
                    //get_search_query();
				?></h1>
			</header><!-- .page-header -->
            
            <div class="page-content">
                <?php
                get_search_form();

                /* Start the Loop */
                while ( have_posts() ) : the_post();

                    /**
                     * Run the loop for the search to output the results.
                     * If you want to overload this in a child theme then include a file
                     * called content-search.php and that will be used instead.
                     */
                    get_template_part( 'template-parts/content', 'search' );

                endwhile;

                codegreen_numbered_navigation();
                ?>
            </div><!-- .page-content -->

        <?php
		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_sidebar();
get_footer();
