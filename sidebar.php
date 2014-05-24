<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package hyde
 */
?>
	<div class="sidebar">

		<div class="container sidebar-sticky">

			<div class="sidebar-about">
				<h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<p class="lead"><?php bloginfo( 'description' ); ?></p>
			</div>

			<?php wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => '',
				'menu_class'     => 'sidebar-nav',
				// 'walker'         => new hyde_walker_nav_menu
			) ); ?>

			<p><?php printf( __( 'Proudly powered by %s', 'hyde' ), 'WordPress' ); ?></p>
		</div>


	</div><!-- #secondary -->
