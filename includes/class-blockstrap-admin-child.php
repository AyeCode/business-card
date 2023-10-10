<?php

if ( class_exists( 'BlockStrap_Admin' ) ) {


	class BlockStrap_Admin_Child extends BlockStrap_Admin {
		public function __construct() {
			parent::__construct();
		}

		/**
		 * Get the theme title.
		 *
		 * @return string|null
		 */
		public function get_theme_title() {
			return __( 'Portfolio', 'portfolio' );
		}

		/**
		 * Get the array of demo pages.
		 *
		 * @return array[]
		 */
		public function get_demo_pages() {
			return array(
				'about'   => array(
					'title' => __( 'About', 'portfolio' ),
					'slug'  => 'about',
					'desc'  => $this->get_template_content( dirname( __FILE__ ) . '/../patterns/about.php' ),
				),
				'education' => array(
					'title' => __( 'Education', 'portfolio' ),
					'slug'  => 'education',
					'desc'  => $this->get_template_content( dirname( __FILE__ ) . '/../patterns/education.php' ),
				),
				'contact' => array(
					'title' => __( 'Contact Us', 'portfolio' ),
					'slug'  => 'contact',
					'desc'  => $this->get_template_content( dirname( __FILE__ ) . '/../patterns/contact.php' ),
				),
				'portfolio' => array(
					'title' => __( 'Portfolio', 'portfolio' ),
					'slug'  => 'portfolio',
					'desc'  => $this->get_template_content( dirname( __FILE__ ) . '/../patterns/portfolio.php' ),
				),
				'services' => array(
					'title' => __( 'Services', 'portfolio' ),
					'slug'  => 'services',
					'desc'  => $this->get_template_content( dirname( __FILE__ ) . '/../patterns/services.php' ),
				),
				'blog'    => array(
					'title'   => __( 'Our Blog', 'portfolio' ),
					'slug'    => 'blog',
					'desc'    => $this->get_template_content( dirname( __FILE__ ) . '/../patterns/blog.php' ),
					'is_blog' => true,
				),
			);
		}


	}
}
