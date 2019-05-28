<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "body-content-wrapper" div.
 *
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo('charset'); ?>" />
		<?php
            if ( is_singular() && pings_open() ) :
                printf( '<link rel="pingback" href="%s">' . "\n", get_bloginfo( 'pingback_url' ) );
            endif;
        ?>
		<meta name="viewport" content="width=device-width" />
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(); ?>>
		<div id="body-content-wrapper">

			<header id="header-main-fixed">

				<div id="header-content-wrapper">

					<div id="open-close-hdr-icon-wrapper">
						<span id="open-close-hdr-icon">
						</span><!-- #open-close-hdr-icon -->
					</div><!-- #header-content-wrapper -->

					<div id="header-logo">
						<?php
							if ( function_exists( 'the_custom_logo' ) ) :
								the_custom_logo();
							endif;

							$header_text_color = get_header_textcolor();

						    if ( 'blank' !== $header_text_color ) :
						?>    
						        <div id="site-identity">
						        	<a href="<?php echo esc_url( home_url('/') ); ?>"
						        		title="<?php esc_attr( get_bloginfo('name') ); ?>">

						        		<h1 class="entry-title">
						        			<?php echo esc_html( get_bloginfo('name') ); ?>
										</h1>
						        	</a>
						        	<strong>
						        		<?php echo esc_html( get_bloginfo('description') ); ?>
						        	</strong>
						        </div><!-- #site-identity -->
						<?php
						    endif;
						?>
					</div><!-- #header-logo -->

					<nav id="navmain">
						<?php wp_nav_menu( array( 'theme_location' => 'primary',
												  'fallback_cb'    => 'wp_page_menu',
												  
												  ) ); ?>
					</nav><!-- #navmain -->
					
					<div class="clear">
					</div><!-- .clear -->

				</div><!-- #header-content-wrapper -->

			</header><!-- #header-main-fixed -->

			<div class="clear">
			</div><!-- .clear -->

			<?php if ( is_front_page() && get_option( 'show_on_front' ) == 'page' ) {

						$frontpage_id = get_option( 'page_on_front' );

						$image = wp_get_attachment_image_src( get_post_thumbnail_id( $frontpage_id ),
									'single-post-thumbnail' );

					} else if ( is_home() && get_option( 'show_on_front' ) == 'page' ) {

						$blog_id = get_option( 'page_for_posts' );

						$image = wp_get_attachment_image_src( get_post_thumbnail_id( $blog_id ),
									'single-post-thumbnail' );

					} else {

						$image = wp_get_attachment_image_src( get_post_thumbnail_id(),
									'single-post-thumbnail' );
					}
				?>

			    <div id="page-header"
			    	<?php if ( $image ) : ?>
			    				style="background-image: url('<?php echo esc_url( $image[0] ); ?>')"
			    	<?php endif; ?>>
			    	<div id="page-header-inner">
			            <h1><?php the_title(); ?></h1>
			        </div>
			    </div>
