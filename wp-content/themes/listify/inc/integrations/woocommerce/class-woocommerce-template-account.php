<?php
/**
 * WooCommerce "My Account" page.
 *
 * @since 1.5.0
 */
class Listify_WooCommerce_Template_Account {

	public function __construct() {
		// remove account navigation
		remove_action( 'woocommerce_account_navigation', 'woocommerce_account_navigation' );

		// maybe add WC tertiary menu items
        add_filter( 'wp_nav_menu_items', array( $this, 'woocommerce_tertiary_menu' ), 10, 2 );

		add_action( 'woocommerce_account_navigation', array( __CLASS__, 'add_avatar_to_dashboard' ), 99 );
	}

	/**
	 * Add the avatar to the My Account dashboard page.
	 * 
	 * @since 1.5.0
	 * @return void
	 */
	public static function add_avatar_to_dashboard() {
		if ( '' != WC()->query->get_current_endpoint() ) {
			return;
		}

		$current_user = wp_get_current_user();

		printf( 
			'<div class="woocommerce-MyAccount-avatar">%s</div>',
			get_avatar( $current_user->user_email, 100 )
		);
	}

	/**
	 * If a WooCommerce link has not been added to the menu automatically output
	 * the WooCommerce 2.6+ My Account navigation items.
	 *
	 * @since 1.5.0
	 * @param array $items
	 * @param array $args
	 * @return array $items
	 */
	public function woocommerce_tertiary_menu( $items, $args ) {
		// if we are below 2.6 don't do anything
		if ( ! function_exists( 'woocommerce_account_navigation' ) ) {
			return $items;
		}

        if ( 'tertiary' != $args->theme_location ) {
            return $items;
        }

		if ( ! is_page( wc_get_page_id( 'myaccount' ) ) ) {
			return $items;
		}

        $enabled = get_post_meta( get_post()->ID, 'enable_tertiary_navigation', true );
		$has_link = false;
		$check_url = wc_get_page_permalink( 'myaccount' );

		if ( false !== strpos( $items, $check_url ) ) {
			$has_link = true;
		}

		// if it's not enabled or no existing link was found add my account links
		if ( ! $enabled ) {
			return $this->my_account_menu_items();
		}

		// the are existing menu items and include the My Account link
		// so let them manage manually
		if ( $items && $has_link ) {
			return $items;
		}

		// There is no My Account link was not found so
		// automatically append the menu items.
		if ( $items && ! $has_link ) {
			return $items . $this->my_account_menu_items();
		}

		return $items;
	}

	/**
	 * The actual navigation output for WooCommerce 2.6+
	 *
	 * @since 1.5.0
	 * @return array $items Navigatino items
	 */
	public function my_account_menu() {
		ob_start();
?>

<div class="nav-menu tertiary">
	<ul>
		<?php echo $this->my_account_menu_items(); ?>
	</ul>
</div>

<?php
		return ob_get_clean();
	}

	/**
	 * The my account menu item HTML markup for WooCommerce 2.6
	 *
	 * @since 1.5.0
	 * @return void
	 */
	public function my_account_menu_items() {
		// if we are below 2.6 don't do anything
		if ( ! function_exists( 'woocommerce_account_navigation' ) ) {
			return;
		}

		ob_start();
?>


<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
	<li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
		<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo esc_html( $label ); ?></a>
	</li>
<?php endforeach; ?>

<?php
		return ob_get_clean();
	}

}
