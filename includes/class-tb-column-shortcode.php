<?php
/**
 * Column shortcode
 */
class Theme_Blvd_Column_Shortcode {

	/*--------------------------------------------*/
	/* Properties, private
	/*--------------------------------------------*/

	/**
	 * A single instance of this class.
	 *
	 * @since 1.4.2
	 */
	private static $instance = null;

	/**
	 * Running total, 0-100. Once this gets to 99+,
	 * we can assume it's time to end the row.
	 *
	 * @since 1.4.2
	 */
	private $total = 0;

	/*--------------------------------------------*/
	/* Constructor
	/*--------------------------------------------*/

	/**
     * Creates or returns an instance of this class.
     *
     * @since 1.4.2
     *
     * @return Theme_Blvd_Frontend_Init A single instance of this class.
     */
	public static function get_instance() {

		if ( self::$instance == null ) {
            self::$instance = new self;
        }

        return self::$instance;
	}

	/*--------------------------------------------*/
	/* Methods, general
	/*--------------------------------------------*/

	/**
	 * Get the column to output.
	 *
	 * @since 1.4.2
	 */
	public function get( $atts, $content = null, $tag = '' ) {

		$output = '';

		$default = array(
			'size' 		=> '',		// The fraction for the width of the column
			'wpautop'	=> 'true',	// Whether wpautop happens within the column
			'class'		=> ''		// CSS class to override framework grid class
	    );
	    $atts = shortcode_atts( $default, $atts );

	    // Setup the fraction of the column width
	    $size = $atts['size'];

	    if ( $tag != 'column' ) {
	    	$size = $this->to_fraction($tag);
	    }

	    // Open row
	    if ( $this->total == 0 ) {
	    	$output .= $this->open_row();
	    }

	    // Add fraction to total
	    $this->add($size);

	    // Setup the CSS class for the column
	    $class = $this->get_class( $size, $atts['class'] );

	    // Start column output
	    $output .= '<div class="'.$class.'">';

	    if ( $atts['wpautop'] == 'true' ) {
	    	$content = wpautop($content);
	    }

	    $output .= do_shortcode($content);

	    $output .= '</div>';

	    // Close row
	    if ( $this->total >= 99 || ( isset($atts[0]) && trim($atts[0] ) == 'last') ) {
	    	$output .= $this->close_row();
	    	$this->total = 0;
	    }

	    return $output;
	}

	/**
	 * Open a row. Requires theme framework 2.5+ to
	 * output anything, but if prior framework versions,
	 * nothing is required to be outputted.
	 *
	 * @since 1.4.2
	 */
	public function open_row() {

		$output = '';

		if ( function_exists( 'themeblvd_get_open_row' ) ) {
			$output = themeblvd_get_open_row();
		}

		return $output;
	}

	/**
	 * Close a row.
	 *
	 * @since 1.4.2
	 */
	public function close_row(  ) {

		$output = '';

		if ( function_exists( 'themeblvd_get_close_row' ) ) {
			$output = themeblvd_get_close_row();
		} else {
			$output .= '<div class="clear"></div>';
		}

		return $output;
	}

	/**
	 * Get CSS class for column
	 *
	 * @since 1.4.2
	 */
	public function get_class( $size, $custom ) {

		$class = '';

		if ( version_compare( TB_FRAMEWORK_VERSION, '2.5.0', '<' ) ) {

			// @deprecated
			$class .= 'column ';
			$class .= $this->to_class($size);
			if ( $this->total >= 99 || ( isset($atts[0]) && trim($atts[0] ) == 'last') ) {
				$class .= ' last';
			}

		} else {

			// In framework 2.5+, life is simple.
			$class .= themeblvd_grid_class($size);

		}

		if ( $custom ) {
			$class .= ' '.$custom;
		}

		return $class;

	}

	/**
	 * Add fraction to total. Once this gets to 99+,
	 * we can assume it's time to end the row.
	 *
	 * @since 1.4.2
	 */
	public function add( $fraction ) {
		$fraction = explode( '/', $fraction );
		$this->total += (intval($fraction[0]) / intval($fraction[1]))*100;
	}


	/*--------------------------------------------*/
	/* Methods, helpers for deprecated stuff
	/*--------------------------------------------*/

	/**
	 * Convert deprecated shortcode tag to accepted fraction.
	 *
	 * @since 1.4.2
	 */
	public function to_fraction( $tag ) {

		$fraction = '1/1';

		switch ( $tag ) {

	        case 'one_sixth' :
	            $fraction = '1/6';
	            break;

	        case 'one_fourth' :
	            $fraction = '1/4';
	            break;

	        case 'one_third' :
	            $fraction = '1/3';
	            break;

	        case 'one_half' :
	            $fraction = '1/2';
	            break;

	        case 'two_third' :
	            $fraction = '2/3';
	            break;

	        case 'three_fourth' :
	            $fraction = '3/4';
	            break;

	        case 'one_fifth' :
	            $fraction = '1/5';
	            break;

	        case 'two_fifth' :
	            $fraction = '2/5';
	            break;

	        case 'three_fifth' :
	            $fraction = '3/5';
	            break;

	        case 'four_fifth' :
	            $fraction = '4/5';
	            break;

	        case 'three_tenth' :
	            $fraction = '3/10';
	            break;

	        case 'seven_tenth' :
	            $fraction = '7/10';
	            break;

	    }

	    return $fraction;
	}

	/**
	 * Convert fraction into old class. As of
	 * Theme Blvd framework v2.5, these classes
	 * are no longer used.
	 *
	 * @since 1.4.2
	 */
	public function to_class( $fraction ) {

		$class = 'grid_';

		$fraction = explode( '/', $fraction );

		$numerator = intval($fraction[0]);
		$denominator = intval($fraction[1]);

		// 12-col?
		$x = (12*$numerator)/$denominator;

		if ( is_int( $x ) ) {
			$class .= $x;
			return $class;
		}

		// 10-col?
		if ( $denominator == 5 ) {
			$class .= 'fifth_'.$numerator;
		} else if ( $denominator == 10 ) {
			$class .= 'tenth_'.$numerator;
		}

		return $class;

	}

}