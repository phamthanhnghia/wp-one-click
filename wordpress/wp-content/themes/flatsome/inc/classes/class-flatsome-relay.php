<?php
/**
 * Flatsome_Relay class.
 *
 * A queried repeater element containerizer, providing functionalities
 * like "Pagination", "Load More", and "Previous/Next" navigation.
 *
 * @author      UX Themes
 * @package     Flatsome
 * @since       3.18.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class Flatsome_Relay
 *
 * @package Flatsome
 */
final class Flatsome_Relay {

	/**
	 * WordPress query.
	 *
	 * @var \WP_Query WP Query
	 */
	private static $query;


	/**
	 * Shortcode defined attributes.
	 *
	 * @var array Attributes.
	 */
	private static $defined_atts;

	/**
	 * Shortcode attributes (including defaults).
	 *
	 * @var array Attributes.
	 */
	private static $atts;

	/**
	 * The relay control that need to be rendered.
	 *
	 * @var string
	 */
	private static $control;

	/**
	 * Show control result count.
	 *
	 * @var bool
	 */
	private static $control_result_count;

	/**
	 * The relay control render position.
	 *
	 * @var string
	 */
	private static $control_position;

	/**
	 * Control alignment: left, center, right.
	 *
	 * @var string
	 */
	private static $control_align;

	/**
	 * Whether relay is enabled on current element or not.
	 *
	 * @var bool
	 */
	private static $enabled;

	/**
	 * Flatsome_Relay constructor.
	 */
	private function __construct() {}

	/**
	 * Enqueue assets.
	 */
	public static function enqueue_assets() {
		wp_enqueue_script( 'flatsome-relay' );
	}

	/**
	 * Set the state.
	 *
	 * @param \WP_Query $query        WP Query.
	 * @param array     $defined_atts Shortcode defined attributes.
	 * @param array     $atts         Shortcode attributes (including defaults).
	 *
	 * @return void
	 */
	private static function set_state( $query, $defined_atts, $atts ) {
		// Main properties.
		self::$query        = $query;
		self::$defined_atts = $defined_atts;
		self::$atts         = $atts;

		// Values by key.
		self::$enabled              = ! empty( $atts['relay'] ) && $atts['type'] !== 'slider' && $atts['type'] !== 'slider-full' && self::$query->max_num_pages > 1;
		self::$control              = $atts['relay'];
		self::$control_result_count = $atts['relay_control_result_count'] === 'true';
		self::$control_position     = $atts['relay_control_position'];
		self::$control_align        = $atts['relay_control_align'];
	}

	/**
	 * Render container open markup.
	 *
	 * Markup needs to be closed with render_container_close()
	 *
	 * @param \WP_Query $query        WP Query.
	 * @param array     $tag          The name of the shortcode.
	 * @param array     $defined_atts Shortcode defined attributes.
	 * @param array     $atts         Shortcode attributes (including defaults).
	 *
	 * @return void
	 */
	public static function render_container_open( $query, $tag, $defined_atts, $atts ) {
		self::set_state( $query, $defined_atts, $atts );
		if ( ! self::$enabled ) return;

		self::enqueue_assets();

		$id      = ! empty( $atts['relay_id'] ) ? $atts['relay_id'] : 'ux-relay-' . wp_rand();
		$classes = array( 'ux-relay', 'ux-relay--' . self::$control );

		if ( ! empty( $atts['relay_class'] ) ) {
			$classes[] = $atts['relay_class'];
		}

		if ( ! empty( $atts['visibility'] ) ) {
			$classes[] = $atts['visibility'];
		}

		$container_atts = array(
			'id'                  => esc_attr( $id ),
			'class'               => esc_attr( implode( ' ', apply_filters( 'flatsome_relay_classes', $classes, self::$control ) ) ),
			'data-flatsome-relay' => esc_attr( wp_json_encode( array(
				'postType'    => $query->query_vars['post_type'],
				'tag'         => $tag,
				'atts'        => self::$defined_atts,
				'currentPage' => $atts['page_number'],
				'totalPages'  => $query->max_num_pages,
				'totalPosts'  => $query->found_posts,
				'postCount'   => $query->post_count,
			) ) ),
		);
		?>
		<div <?php echo flatsome_html_atts( $container_atts ); ?>>
		<?php
		self::header();
	}

	/**
	 * Render container close markup.
	 *
	 * @return void
	 */
	public static function render_container_close() {
		if ( ! self::$enabled ) return;
		self::footer();
		?>
		</div>
		<?php
	}

	/**
	 * Container top section.
	 *
	 * @return void
	 */
	private static function header() {
		if ( self::$control_position !== 'top' && self::$control_position !== 'top-bottom' ) return;

		$classes = [ 'ux-relay__control', 'ux-relay__control--top', 'container', 'pb-half' ];
		if ( self::$control_align ) {
			$classes[] = 'text-' . self::$control_align;
		}
		?>
		<div class="<?php echo esc_attr( implode( ' ', apply_filters( 'flatsome_relay_control_classes', $classes, self::$control, 'top' ) ) ); ?>">
			<?php self::control( self::$control ); ?>
		</div>
		<?php
	}

	/**
	 * Container bottom section.
	 *
	 * @return void
	 */
	private static function footer() {
		if ( self::$control_position !== 'bottom' && self::$control_position !== 'top-bottom' ) return;

		$classes = [ 'ux-relay__control', 'ux-relay__control--bottom', 'container', 'pb-half' ];
		if ( self::$control_align ) {
			$classes[] = 'text-' . self::$control_align;
		}
		?>
		<div class="<?php echo esc_attr( implode( ' ', apply_filters( 'flatsome_relay_control_classes', $classes, self::$control, 'bottom' ) ) ); ?>">
			<?php self::control( self::$control ); ?>
		</div>
		<?php
	}

	/**
	 * The interaction control.
	 *
	 * @param string $control Type of control.
	 *
	 * @return void
	 */
	private static function control( $control = 'pagination' ) {
		switch ( $control ) {
			case 'pagination':
				self::pagination( array(
					'current' => self::$atts['page_number'],
				) );
				break;
			case 'load-more':
				?>
				<button class="ux-relay__button ux-relay__load-more-button button primary mb-0">
					<?php esc_html_e( 'Load more', 'flatsome' ); ?>
					<?php
					if ( self::$control_result_count ) {
						printf( '<span class="ux-relay__result-count">(<span class="ux-relay__current-count">%d</span> / %d)</span>', self::$query->post_count, self::$query->found_posts ); // phpcs:ignore WordPress.Security.EscapeOutput
					}
					?>
				</button>
				<?php
				break;
			case 'prev-next':
				?>
				<button class="ux-relay__button ux-relay__nav-button ux-relay__nav-button--prev" data-flatsome-dir="prev" disabled aria-label="<?php esc_attr_e( 'Previous', 'flatsome' ); ?>">
					<svg aria-hidden="true" class="ux-relay__button-icon" viewBox="0 0 100 100">
						<path d="M 10,50 L 60,100 L 70,90 L 30,50  L 70,10 L 60,0 Z"></path>
					</svg>
				</button>
				<button class="ux-relay__button ux-relay__nav-button ux-relay__nav-button--next" data-flatsome-dir="next" aria-label="<?php esc_attr_e( 'Next', 'flatsome' ); ?>">
					<svg aria-hidden="true" class="ux-relay__button-icon" viewBox="0 0 100 100">
						<path d="M 10,50 L 60,100 L 70,90 L 30,50  L 70,10 L 60,0 Z" transform="translate(100, 100) rotate(180)"></path>
					</svg>
				</button>
				<?php
				break;
		}
	}

	/**
	 * Render pagination.
	 *
	 * @param array $args optional args.
	 *
	 * @return void
	 */
	private static function pagination( $args = array() ) {
		$prev_arrow = is_rtl() ? get_flatsome_icon( 'icon-angle-right' ) : get_flatsome_icon( 'icon-angle-left' );
		$next_arrow = is_rtl() ? get_flatsome_icon( 'icon-angle-left' ) : get_flatsome_icon( 'icon-angle-right' );

		$defaults = array(
			'base'      => '#/page/%#%',
			'format'    => '#/page/%#%',
			'current'   => 1,
			'total'     => self::$query->max_num_pages,
			'mid_size'  => 3,
			'type'      => 'array',
			'prev_text' => $prev_arrow,
			'next_text' => $next_arrow,
			'add_args'  => array(),
		);

		$args = wp_parse_args( $args, $defaults );

		$pages = paginate_links( apply_filters( 'flatsome_relay_pagination_args', $args ) );

		if ( ! is_array( $pages ) ) return;

		echo '<ul class="ux-relay__pagination page-numbers nav-pagination links">';
		foreach ( $pages as $page ) {
			$page = str_replace( 'page-numbers', 'page-number', $page );
			$page = str_replace( '<a class="next page-number', '<a aria-label="' . esc_attr__( 'Next', 'flatsome' ) . '" class="next page-number', $page );
			$page = str_replace( '<a class="prev page-number', '<a aria-label="' . esc_attr__( 'Previous', 'flatsome' ) . '" class="prev page-number', $page );

			// Create '#/page/x' hrefs without site URL and query args.
			$page = preg_replace_callback( '/href="([^"]*)"/', function ( $matches ) {
				$href = $matches[1];
				$pos  = strrpos( $href, '#' );
				if ( $pos !== false ) {
					return 'href="' . substr( $href, $pos ) . '"';
				}

				return $matches[0];
			}, $page );

			echo "<li>$page</li>"; // phpcs:ignore WordPress.Security.EscapeOutput
		}
		echo '</ul>';
	}
}
