<?php
/*
	Plugin Name: Testimonials
	Plugin URI: 
	Description: Testimonials post type
	Version: 0.1
	Author: Jem Turner
	Author URI: http://jemturner.co.uk
	License: GPL
*/


if( !class_exists( 'jtTestimonials' ) ) {
	class jtTestimonials {
	
		public function __construct() {
			add_action( 'init', array( $this, 'testimonial_post_type' ) );
			
			add_shortcode( 'testimonials', array( $this, 'display_testimonials' ) );
		}

		function testimonial_post_type() {
			$singular = "Testimonial";
			$plural = "Testimonials";
			
			$labels = array(
				'name' => __( $plural ),
				'singular_name' => __( $singular ),
				'add_new' => __( 'Add New' ),
				'add_new_item' => __( 'Add New ' . $singular ),
				'edit_item' => __( 'Edit ' . $singular ),
				'new_item' => __( 'New ' . $singular ),
				'all_items' => __( 'All ' . $plural ),
				'view_item' => __( 'View ' . $singular ),
				'search_items' => __( 'Search ' . $plural ),
				'not_found' => __( 'No '. strtolower( $plural ) .' found' ),
				'not_found_in_trash' => __( 'No '. strtolower( $plural ) .' found in Trash' ), 
				'parent_item_colon' => ''
			);
		
			register_post_type( 'testimonial',
				array(
					'labels' => $labels,
					'public' => true,
					'menu_position' => 20,
					'rewrite' => array( 'slug' => 'testimonial', 'with_front' => false ),		
					'has_archive' => 'testimonials',
					'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'page-attributes' ),
					'menu_icon'   => 'dashicons-groups'
				)
			);
		}
		
		function display_testimonials() {
			ob_start();
			
			$args = array(
				'post_type' => 'testimonial',
				'posts_per_page' => -1			
			);
			
			$testimonials = new WP_Query( $args ); 
			
			if ( $testimonials->have_posts() ) :
				while( $testimonials->have_posts() ) :
					$testimonials->the_post();
?>
					<div class="testimonial cf">
						<blockquote><?php the_content(); ?></blockquote>
						<p><cite><?php the_title(); ?></cite></p>
					</div>
<?php
				endwhile;
			endif;
			
			return ob_get_clean();
		}
	}
	$jtTestimonials = new jtTestimonials();
}
