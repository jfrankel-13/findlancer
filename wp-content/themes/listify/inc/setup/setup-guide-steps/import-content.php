<p class="alignleft"><a href="<?php echo get_template_directory_uri(); ?>/inc/setup/assets/images/steps/setup-content.gif">
    <img src="<?php echo get_template_directory_uri(); ?>/inc/setup/assets/images/steps/setup-content.gif" width="430" alt="" />
</a></p>

<p><?php _e( 'Installing the demo content is not required to use this theme. It is simply meant to provide a way to get a feel for the theme without having to manually set up all of your own content. <strong>If you choose not to import the demo content you need to make sure you manually create all necessary page templates for your website.</strong>', 'listify' ); ?></p>

<p><?php _e( 'The Listify theme package includes multiple demo content .XML files. This is what you will upload to the WordPress importer. Depending on the plugins you have activated or the intended use of your website you may not need to upload all .XML files.', 'listify' ); ?></p>

<p><a href="<?php echo esc_url( admin_url( 'import.php' ) ); ?>" class="button button-primary button-large"><?php _e( 'Import Content', 'listify' ); ?></a></p>
