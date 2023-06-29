<?php
/**
 * Widget Area Section
 */

function cws_sidebars() {

	/* Blog Sidebar sidebar */
	register_sidebar(
		array(
			'id'            => 'blog-sidebar',
			'name'          => __( 'Blog Sidebar' ),
			'description'   => __( 'This is the sidebar for the blog, archive and single post.' ),
			'before_widget' => '<div class="sidebar-item"><div id="%1$s" class="%2$s">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<div class="sidebar-title">',
			'after_title'   => '</div>',
		)
	);

	/* Generic Sidebar */
	register_sidebar(
		array(
			'id'            => 'generic-sidebar',
			'name'          => __( 'Generic Sidebar' ),
			'description'   => __( 'This is the sidebar for the generic page.' ),
			'before_widget' => '<div class="sidebar-item"><div id="%1$s" class="%2$s">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<div class="sidebar-title">',
			'after_title'   => '</div>',
		)
	);

	 /* Archive Sidebar */
	register_sidebar(
		array(
			'id'            => 'archive-sidebar',
			'name'          => __( 'Archive Sidebar' ),
			'description'   => __( 'This is the sidebar for the archive pages.' ),
			'before_widget' => '<div class="sidebar-item"><div id="%1$s" class="%2$s">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<div class="sidebar-title">',
			'after_title'   => '</div>',
		)
	);
}

add_action( 'widgets_init', 'cws_sidebars' );

/**
 * Custom Widgets
 */

function cws_widgets() {
	register_widget( 'cw_form_widget' ); // Form Widget
	register_widget( 'cw_cta_widget' ); // CTA Widget
	register_widget( 'cw_awards_widget' ); // Awards Widget
	register_widget( 'cw_related_pages_widget' ); // Related pages Widget
	register_widget( 'cw_custom_sidebar_widget' ); // Custom Sidebar Widget
	register_widget( 'cw_testimonial_widget' ); // Testimonial Widget
	register_widget( 'cw_team_widget' ); // Team Widget
	register_widget( 'cw_results_widget' ); // Results Widget
}

add_action( 'widgets_init', 'cws_widgets' );

// Add widgets by default
function cw_add_default_widgets() {
	$active_widgets = get_option( 'sidebars_widgets' );
	$counter        = 100;

	$array_sidebar = array(
		'about-sidebar'                => array(
			'cw_form_widget'           => array(
				'title' => '',
			),
			'cw_custom_sidebar_widget' => array(
				'title' => '',
			),
		),
		'attorney-sidebar'             => array(
			'cw_results_widget' => array(
				'title'        => '',
				'button_title' => '',
				'button_link'  => '',
				'result'       => cw_default_widget_pt_id( 'result' ),
			),
			'cw_awards_widget'  => array(
				'title' => '',
			),
			'cw_team_widget'    => array(
				'title' => '',
			),
		),
		'404-sidebar'                  => array(
			'cw_form_widget'    => array(
				'title' => '',
			),
			'cw_results_widget' => array(
				'title'        => '',
				'button_title' => '',
				'button_link'  => '',
				'result'       => cw_default_widget_pt_id( 'result' ),
			),
		),
		'blog-sidebar'                 => array(
			'search'     => array(
				'title' => 'Search',
			),
			'categories' => array(
				'title'        => 'Categories',
				'count'        => 0,
				'hierarchical' => 0,
				'dropdown'     => 0,
			),
			'archives'   => array(
				'title'    => 'Archives',
				'count'    => 0,
				'dropdown' => 0,
			),
		),
		'practice-area-top-sidebar'    => array(
			'cw_form_widget'          => array(
				'title' => '',
			),
			'cw_related_pages_widget' => array(
				'title' => '',
			),
		),
		'practice-area-bottom-sidebar' => array(
			'cw_cta_widget'         => array(
				'title'        => 'No Fee Unless we win',
				'phone'        => '1 (800) 000-0000',
				'button'       => 'Get Your Free Case Review',
				'button_class' => 'btn-std',
			),
			'cw_awards_widget'      => array(
				'title' => '',
			),
			'cw_testimonial_widget' => array(
				'title'       => '',
				'testimonial' => cw_default_widget_pt_id( 'testimonial' ),
			),
		),
		'location-top-sidebar'         => array(
			'cw_related_pages_widget'  => array(
				'title' => '',
			),
			'cw_custom_sidebar_widget' => array(
				'title' => '',
			),
		),
		'location-bottom-sidebar'      => array(
			'cw_team_widget' => array(
				'title' => '',
			),
		),
		'generic-sidebar'              => array(
			'cw_awards_widget' => array(
				'title' => '',
			),
			'cw_form_widget'   => array(
				'title' => '',
			),
			'cw_team_widget'   => array(
				'title' => '',
			),
		),
	);

	foreach ( $array_sidebar as $sidebar_name => $sidebar_args ) {

		// If widget area is empty
		if ( empty( $active_widgets[ $sidebar_name ] ) ) {

			// adding default widgets
			foreach ( $sidebar_args as $widget_name => $widget_args ) {

				$counter++;

				// we are adding the widget to the specific widget area
				$active_widgets[ $sidebar_name ][] = $widget_name . '-' . $counter;

				// getting all the widgets from the same type (ex. form widget)
				$widget_options = get_option( 'widget_' . $widget_name, array() );

				// updating the widgets options for that specific widget
				foreach ( $widget_args as $key => $val ) {
					$widget_options[ $counter ][ $key ] = $val;
				}
				update_option( 'widget_' . $widget_name, $widget_options );
			}
		}
	}

	// save new widgets to DB
	update_option( 'sidebars_widgets', $active_widgets );
}
add_action( 'widgets_init', 'cw_add_default_widgets' );

//Clear widgets after switching theme
function clear_theme_widgets() {
	update_option('sidebars_widgets', array());
}
add_action('after_switch_theme', 'clear_theme_widgets', 10);
