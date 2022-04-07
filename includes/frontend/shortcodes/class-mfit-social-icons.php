<?php
/**
 * Social Icons Shortcode Class.
 *
 * This class renders social icons in the frontend.
 *
 * @package MAXX Fitness
 * @since   1.0.0
 */

/**
 * Social Icons Shortcode Class.
 *
 * @since  1.0.0
 */
class Mfit_Social_Icons {

	/**
	 * Refers to a single instance of this class.
	 *
	 * @static
	 * @access public
	 * @var null|object
	 * @since 1.0.0
	 */
	public static $instance = null;

	/**
	 * Access the single instance of this class.
	 *
	 * @static
	 * @access public
	 * @return Mfit_Social_Icons
	 * @since 1.0.0
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Method to load the shortcode.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @return void
	 */
	public function register() {
		add_shortcode( 'mfit_social_icons', array( $this, 'shortcode' ) );
	}

	/**
	 * Method to render the shortcodes.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @param mixed $atts shortcode attributes.
	 * @return void|string
	 */
	public function shortcode( $atts ) {
		$atts   = shortcode_atts(
			array(),
			$atts
		);
		$result = '';

		ob_start();

		$social_icons = get_theme_mod( 'mfit_social_media_profiles' );

		if ( empty( $social_icons ) ) {
			return $result;
		}
		?>
		<div class="social-icon-wrapper">
			<ul class="mb-0 list-inline">
				<?php
				foreach ( $social_icons as $social ) {
					echo '<li class="list-inline-item"><a href="' . esc_url( $social['profile_url'] ) . '" target="_blank"><i class="' . esc_attr( $social['type_image'] ) . '"></i></a></li>';
				}
				?>
			</ul>
		</div>


		<?php
		$result .= ob_get_clean();

		return $result;
	}
}
