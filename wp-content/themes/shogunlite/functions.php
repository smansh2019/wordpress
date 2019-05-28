<?php
/**
 * ShogunLite Theme: Functions and Definitions
 */

if ( ! function_exists( 'shogunlite_setup' ) ) :

	function shogunlite_setup() {

		load_theme_textdomain( 'shogunlite', get_template_directory() . '/languages' );

		add_theme_support( 'automatic-feed-links' );

		add_theme_support( 'title-tag' );

		add_theme_support( 'post-thumbnails' );

		add_theme_support( 'html5', array('comment-form', 'comment-list',
			'gallery', 'caption', ) );

		add_editor_style( array( 'css/editor-style.css', 
			get_template_directory_uri() . '/css/font-awesome.css', shogunlite_fonts_url(), ) );

		add_theme_support( 'custom-background', array ('default-color'  => '#ffffff') );

		$GLOBALS['content_width'] = 900;

		register_nav_menus( array( 'primary'   => __( 'Primary Menu', 'shogunlite' ), ) );

	    add_theme_support( 'custom-logo', array( 'flex-height' => false, 'flex-width'  => false,
	    	'header-text' => array( 'site-title', 'site-description' ), ) );
	}
endif; // shogunlite_setup
add_action( 'after_setup_theme', 'shogunlite_setup' );

if ( ! function_exists( 'shogunlite_fonts_url' ) ) :
	// Load Google Font url used in the shogunlite theme
	function shogunlite_fonts_url() {

	    $fonts_url = '';
	 
	    /* Translators: If there are characters in your language that are not
	    * supported by Arimo, translate this to 'off'. Do not translate
	    * into your own language.
	    */
	    $questrial = _x( 'on', 'Arimo font: on or off', 'shogunlite' );

	    if ( 'off' !== $questrial ) {
	        $font_families = array();
	 
	        $font_families[] = 'Arimo';
	 
	        $query_args = array(
	            'family' => urlencode( implode( '|', $font_families ) ),
	            'subset' => urlencode( 'latin,latin-ext' ),
	        );
	 
	        $fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
	    }
	 
	    return $fonts_url;
	}
endif; // shogunlite_fonts_url

if ( ! function_exists( 'shogunlite_load_scripts' ) ) :
	// the main function to load scripts in the shogunlite theme
	function shogunlite_load_scripts() {
		// load main stylesheet.
		wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.css', array( ) );
		wp_enqueue_style( 'shogunlite-style', get_stylesheet_uri(), array() );
		
		wp_enqueue_style( 'shogunlite-fonts', shogunlite_fonts_url(), array(), null );
		
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		// Load Utilities JS Script
		wp_enqueue_script( 'shogunlite-utilities',
			get_template_directory_uri() . '/js/utilities.js', array( 'jquery', ) );
	}
endif; // shogunlite_load_scripts
add_action( 'wp_enqueue_scripts', 'shogunlite_load_scripts' );

if ( ! function_exists( 'shogunlite_widgets_init' ) ) :
	//	widgets-init action handler. Used to register widgets and register widget areas
	function shogunlite_widgets_init() {	
		// Register Sidebar Widget.
		register_sidebar( array (
							'name'	 		 =>	 __( 'Sidebar Widget Area', 'shogunlite'),
							'id'		 	 =>	 'sidebar-widget-area',
							'description'	 =>  __( 'The sidebar widget area', 'shogunlite'),
							'before_widget'	 =>  '',
							'after_widget'	 =>  '',
							'before_title'	 =>  '<div class="sidebar-before-title"></div><h3 class="sidebar-title">',
							'after_title'	 =>  '</h3><div class="sidebar-after-title"></div>',
						) );
	}
endif; // shogunlite_widgets_init
add_action( 'widgets_init', 'shogunlite_widgets_init' );

if ( ! function_exists( 'shogunlite_custom_header_setup' ) ) :
  function shogunlite_custom_header_setup() {
  	add_theme_support( 'custom-header', array (
                         'default-image'          => '',
                         'flex-height'            => true,
                         'flex-width'             => true,
                         'uploads'                => true,
                         'width'                  => 900,
                         'height'                 => 100,
                         'default-text-color'     => '#FFFFFF',
                         'wp-head-callback'       => 'shogunlite_header_style',
                      ) );
  }
endif; // shogunlite_custom_header_setup
add_action( 'after_setup_theme', 'shogunlite_custom_header_setup' );

if ( ! function_exists( 'shogunlite_header_style' ) ) :
  // Styles the header image and text displayed on the blog.
  function shogunlite_header_style() {

  	$header_text_color = get_header_textcolor();

      if ( ! has_header_image()
          && ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color
               || 'blank' === $header_text_color ) ) {

          return;
      }

      $headerImage = get_header_image();
  ?>
      <style id="shogunlite-custom-header-styles" type="text/css">

          <?php if ( has_header_image() ) : ?>

                  #header-main-fixed {background-image: url("<?php echo esc_url( $headerImage ); ?>");}

          <?php endif; ?>

          <?php if ( get_theme_support( 'custom-header', 'default-text-color' ) !== $header_text_color
                      && 'blank' !== $header_text_color ) : ?>

                  #header-main-fixed, #header-main-fixed h1.entry-title {color: #<?php echo sanitize_hex_color_no_hash( $header_text_color ); ?>;}

          <?php endif; ?>
      </style>
  <?php
  }
endif; // End of shogunlite_header_style.

if ( class_exists('WP_Customize_Section') ) {
	class shogunlite_Customize_Section_Pro extends WP_Customize_Section {

		// The type of customize section being rendered.
		public $type = 'shogunlite';

		// Custom button text to output.
		public $pro_text = '';

		// Custom pro button URL.
		public $pro_url = '';

		// Add custom parameters to pass to the JS via JSON.
		public function json() {
			$json = parent::json();

			$json['pro_text'] = $this->pro_text;
			$json['pro_url']  = esc_url( $this->pro_url );

			return $json;
		}

		// Outputs the template
		protected function render_template() { ?>

			<li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }} cannot-expand">

				<h3 class="accordion-section-title">
					{{ data.title }}

					<# if ( data.pro_text && data.pro_url ) { #>
						<a href="{{ data.pro_url }}" class="button button-primary alignright" target="_blank">{{ data.pro_text }}</a>
					<# } #>
				</h3>
			</li>
		<?php }
	}
}

/**
 * Singleton class for handling the theme's customizer integration.
 */
final class shogunlite_Customize {

	// Returns the instance.
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	// Constructor method.
	private function __construct() {}

	// Sets up initial actions.
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}

	// Sets up the customizer sections.
	public function sections( $manager ) {

		// Load custom sections.

		// Register custom section types.
		$manager->register_section_type( 'shogunlite_Customize_Section_Pro' );

		// Register sections.
		$manager->add_section(
			new shogunlite_Customize_Section_Pro(
				$manager,
				'shogunlite',
				array(
					'title'    => esc_html__( 'ShogunPro', 'shogunlite' ),
					'pro_text' => esc_html__( 'Upgrade to Pro', 'shogunlite' ),
					'pro_url'  => esc_url( 'https://tishonator.com/product/shogunpro' )
				)
			)
		);
	}

	// Loads theme customizer CSS.
	public function enqueue_control_scripts() {

		wp_enqueue_script( 'shogunlite-customize-controls', trailingslashit( get_template_directory_uri() ) . 'js/customize-controls.js', array( 'customize-controls' ) );

		wp_enqueue_style( 'shogunlite-customize-controls', trailingslashit( get_template_directory_uri() ) . 'css/customize-controls.css' );
	}
}

// Doing this customizer thang!
shogunlite_Customize::get_instance();
