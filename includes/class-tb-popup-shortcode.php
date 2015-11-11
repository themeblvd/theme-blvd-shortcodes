<?php
/**
 * Popup shortcode. Keep track of all instances of the
 * [popup] shortcode being used, and then output all
 * of the modal windows in the footer of the website.
 */
class Theme_Blvd_Popup_Shortcode {

    /*--------------------------------------------*/
	/* Properties, private
	/*--------------------------------------------*/

	/**
	 * A single instance of this class.
	 *
	 * @since 1.5.9.1
	 */
	private static $instance = null;

    /**
	 * Keeps track of popups to be outputted in footer.
	 *
	 * @since 1.5.9.1
	 */
	private $popups = array();

    /*--------------------------------------------*/
	/* Constructor
	/*--------------------------------------------*/

	/**
     * Creates or returns an instance of this class.
     *
     * @since 1.5.9.1
     *
     * @return Theme_Blvd_Frontend_Init A single instance of this class.
     */
	public static function get_instance() {

		if ( self::$instance == null ) {
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
        add_action( 'wp_footer', array($this, 'output') );
    }

    /*--------------------------------------------*/
	/* Methods, general
	/*--------------------------------------------*/

    /**
	 * Add a popup to be queued for footer.
	 *
	 * @since 1.5.9.1
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

                // Classes for popup
                $class = 'modal';

                if ( $popup['animate'] == 'true' ) {
                	$class .= ' fade';
                }

                echo '<div class="'.$class.'" id="'.$popup['id'].'" tabindex="-1" role="dialog" aria-hidden="true">';
                echo '<div class="modal-dialog">';
                echo '<div class="modal-content">';

                if ( $popup['header'] ) {
                	echo '<div class="modal-header">';
                	echo '<button type="button" class="close" data-dismiss="modal">×</button>';
                	echo '<h3>'.$popup['header'].'</h3>';
                	echo '</div><!-- modal-header (end) -->';
                }

                echo '<div class="modal-body">';
                echo apply_filters('themeblvd_the_content', $popup['content']);
                echo '</div><!-- .modal-body (end) -->';
                echo '<div class="modal-footer">';

                $class = 'btn btn-default';

                if ( apply_filters( 'themeblvd_btn_gradient', false ) ) {
                    $class .= ' btn-gradient';
                }

                echo '<a href="#" class="'.$class.'" data-dismiss="modal">'.themeblvd_get_local('close').'</a>';

                echo '</div><!-- .modal-footer (end) -->';

                echo '</div><!-- .modal-content (end) -->';
                echo '</div><!-- .modal-dialog (end) -->';
                echo '</div><!-- .modal (end) -->';

            }
        }

    }

}
