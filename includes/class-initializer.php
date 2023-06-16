<?php
/**
 * Newspack Hub plugin initialization.
 *
 * @package Newspack
 */

namespace Newspack_Network;

/**
 * Class to handle the plugin initialization
 */
class Initializer {

	/**
	 * Runs the initialization.
	 */
	public static function init() {
		Admin::init();

		if ( Site_Role::is_hub() ) {
			Hub\Admin::init();
			Hub\Nodes::init();
			Hub\Webhook::init();
			Hub\Pull_Endpoint::init();
			Hub\Event_Listeners::init();
			Hub\Database\Subscriptions::init();
			Hub\Database\Orders::init();
		}

		if ( Site_Role::is_node() ) {
			Node\Settings::init();
			if ( Node\Settings::get_hub_url() ) {
				Node\Webhook::init();
				Node\Pulling::init();
				Node\Canonical_Url::init();
			}
		}
		
		Data_Listeners::init();

		register_activation_hook( NEWSPACK_HUB_PLUGIN_FILE, [ __CLASS__, 'activation_hook' ] );
	}

	/**
	 * Runs on plugin activation.
	 *
	 * @return void
	 */
	public static function activation_hook() {
		add_role( 'network_reader', __( 'Network Reader', 'newspack-hub' ) ); // phpcs:ignore
	}

}
