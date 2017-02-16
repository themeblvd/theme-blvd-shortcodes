<?php
/**
 * This file contains specific popup shortcode
 * elements.
 *
 * @package Theme Blvd Shortcodes
 */

/**
 * Popup shortcode. Keep track of all instances of the
 * [popup] shortcode being used, and then output all
 * of the modal windows in the footer of the website.
 */
class Theme_Blvd_Popup_Shortcode {

	/**
	 * A single instance of this class.
	 *
	 * @since 1.5.9.1
	 *
	 * @var Theme_Blvd_Popup_Shortcode
	 */
	private static $instance = null;

	/**
	 * Keeps track of popups to be outputted in footer.
	 *
	 * @since 1.5.9.1
	 *
	 * @var array
	 */
	private $popups = array();

	/**
	 * Creates or returns an instance of this class.
	 *
	 * @since 1.5.9.1
	 *
	 * @return Theme_Blvd_Popup_Shortcode A single instance of this class.
	 */
	public static function get_instance() {

		if ( null === self::$instance ) {

	        self::$instance = new self;

	    }

	    return self::$instance;

	}

	/**
	 * Constructor. Hook everything in.
	 *
	 * @since 1.5.9.1
	 */
	public function __construct() {

		add_action( 'wp_footer', array( $this, 'output' ) );

	}

	/**
	 * Add a popup to be queued for footer.
	 *
	 * @since 1.5.9.1
	 *
	 * @param array $popup Popup to add to global scope array.
	 */
	public function add( $popup ) {

		$this->popups[] = $popup;

	}

	/**
	 * Add a popup to be queued for footer.
	 *
	 * @since 1.5.9.1
	 */
	public function output() {

	    if ( $this->popups ) {

	        foreach ( $this->popups as $popup ) {

	            $class = 'modal';

	            if ( 'true' === $popup['animate'] ) {

	            	$class .= ' fade';

	            }

	            echo '<div class="' . esc_attr( $class ) . '" id="' . esc_attr( $popup['id'] ) . '" tabindex="-1" role="dialog" aria-hidden="true">';
	            echo '<div class="modal-dialog">';
	            echo '<div class="modal-content">';

	            if ( $popup['header'] ) {

	            	echo '<div class="modal-header">';
	            	echo '<button type="button" class="close" data-dismiss="modal">×</button>';
	            	echo '<h3>' . esc_html( $popup['header'] ) . '</h3>';
	            	echo '</div><!-- modal-header (end) -->';

	            }

	            echo '<div class="modal-body">';

				/**
				 * Standard filter in Theme Blvd Framework, where
				 * sanitization is applied.
				 *
				 * @since 1.5.9.1
				 *
				 * @var string
				 */
				echo apply_filters( 'themeblvd_the_content', $popup['content'] ); // WPCS: sanitization ok.

				echo '</div><!-- .modal-body (end) -->';
	            echo '<div class="modal-footer">';

	            $class = 'btn btn-default';

				/**
				 * Standard filter in Theme Blvd Framework, where
				 * deprecated Bootstrap button gradients are applied.
				 *
				 * @since 1.5.9.1
				 *
				 * @var bool
				 */
	            if ( apply_filters( 'themeblvd_btn_gradient', false ) ) {

	                $class .= ' btn-gradient';

	            }

	            echo '<a href="#" class="' . esc_attr( $class ) . '" data-dismiss="modal">' . esc_html( themeblvd_get_local( 'close' ) ) . '</a>';

	            echo '</div><!-- .modal-footer (end) -->';

	            echo '</div><!-- .modal-content (end) -->';
	            echo '</div><!-- .modal-dialog (end) -->';
	            echo '</div><!-- .modal (end) -->';

	        }
	    }

	}

}
