<?php
/**
 * The template for displaying the search page
 *
 * @package codeGreen
 */

get_header(); ?>

	<div id="primary" class="content-area col-md-8">
		<main id="main" class="site-main">

			<section class="search-page">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( 'Search page', 'codegreen' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<?php
						get_search_form();

						the_widget( 'WP_Widget_Recent_Posts', '', array(
                            'before_title' => '<h2 class="widget-title">',
                            'after_title' => '</h2><div class="widget-content">',
                            'after_widget' => '</div></div>'
                        ) );
					?>

					<div class="widget widget_categories">
						<h2 class="widget-title"><?php esc_html_e( 'Most Used Categories', 'codegreen' ); ?></h2>
                        <div class="widget-content">
                            <ul>
                            <?php
                                wp_list_categories( array(
                                    'orderby'    => 'count',
                                    'order'      => 'DESC',
                                    'show_count' => 1,
                                    'title_li'   => '',
                                    'number'     => 10,
                                ) );
                            ?>
                            </ul>
                        </div>
					</div><!-- .widget -->

					<?php
						the_widget( 'WP_Widget_Archives', 'dropdown=1', array(
                            'before_title' => '<h2 class="widget-title">',
                            'after_title' => '</h2><div class="widget-content">',
                            'after_widget' => '</div></div>'
                        ) );

						the_widget( 'WP_Widget_Tag_Cloud', '', array(
                            'before_title' => '<h2 class="widget-title">',
                            'after_title' => '</h2><div class="widget-content">',
                            'after_widget' => '</div></div>'
                        ) );
					?>

				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();