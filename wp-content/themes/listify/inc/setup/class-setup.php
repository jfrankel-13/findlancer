<?php
/**
 * Setup Listify
 *
 * @see https://github.com/astoundify/setup-guide
 */
class Listify_Setup {

	/**
	 * Start things up.
	 *
	 * @since 1.5.0
	 * @return void
	 */
	public static function init() {
		if ( ! is_admin() ) {
			return;
		}

		self::includes();
		self::setup_guide();
	}

	public static function includes() {
		include_once( dirname( __FILE__ ) . '/_setup-guide/class-astoundify-setup-guide.php' );
	}

	/**
	 * Create the setup guide.
	 *
	 * @since 1.5.0
	 * @return void
	 */
	public static function setup_guide() {
		add_action( 'astoundify_setup_guide_intro', array( __CLASS__, '_setup_guide_intro' ) );

		$steps = include_once( dirname( __FILE__ ) . '/setup-guide-steps/_step-list.php' );

		Astoundify_Setup_Guide::init( array(
			'steps' => $steps,
			'steps_dir' => get_template_directory() . '/inc/setup/setup-guide-steps',
			'strings' => array(
				'page-title' => __( 'Setup %s', 'listify' ),
				'menu-title' => __( 'Setup Guide', 'listify' ),
				'intro-title' => __( 'Welcome to %s', 'listify' ),
				'step-complete' => __( 'Completed', 'listify' ),
				'step-incomplete' => __( 'Not Complete', 'listify' )
			),
			'stylesheet_uri' => get_template_directory_uri() . '/inc/setup/_setup-guide/style.css',
		) );
	}

	/**
	 * The introduction text for the setup guide page.
	 *
	 * @since 1.5.0
	 * @return void
	 */
	public static function _setup_guide_intro() {
?>
<p class="about-text"><?php printf( __( 'The last directory you will ever buy. Use the steps below to finish setting up your new website. If you have more questions please <a href="%s">review the documentation</a>.', 'listify' ), 'http://listify.astoundify.com' ); ?></p>

<div class="setup-guide-theme-badge"><img src="<?php echo get_template_directory_uri(); ?>/inc/setup/assets/images/banner.jpg" width="140" alt="" /></div>

<p class="helpful-links">
    <a href="http://listify.astoundify.com" class="button button-primary js-trigger-documentation"><?php _e( 'Search Documentation', 'listify' ); ?></a>&nbsp;
    <a href="https://astoundify.com/go/astoundify-support/" class="button button-secondary"><?php _e( 'Submit a Support Ticket', 'listify' ); ?></a>&nbsp;
</p>

<script>
	jQuery(document).ready(function($) {
		$('.js-trigger-documentation').click(function(e) {
			e.preventDefault();
			HS.beacon.open();
		});
	});
</script>
<script>!function(e,o,n){window.HSCW=o,window.HS=n,n.beacon=n.beacon||{};var t=n.beacon;t.userConfig={},t.readyQueue=[],t.config=function(e){this.userConfig=e},t.ready=function(e){this.readyQueue.push(e)},o.config={modal: true, docs:{enabled:!0,baseUrl:"//astoundify-listify.helpscoutdocs.com/"},contact:{enabled:!1,formId:"f830bbd3-6615-11e5-8846-0e599dc12a51"}};var r=e.getElementsByTagName("script")[0],c=e.createElement("script");c.type="text/javascript",c.async=!0,c.src="https://djtflbt20bdde.cloudfront.net/",r.parentNode.insertBefore(c,r)}(document,window.HSCW||{},window.HS||{});</script>
<?php
	}

	public static function get_template_name() {
		// if the current theme is a child theme find the parent
		$current_child_theme = wp_get_theme();

		if ( false !== $current_child_theme->parent() ) {
			$current_theme = wp_get_theme( $current_child_theme->get_template() );
		} else {
			$current_theme = wp_get_theme();
		}

		$template = $current_theme->get_template();

		return $template;
	}
	
}

Listify_Setup::init();
