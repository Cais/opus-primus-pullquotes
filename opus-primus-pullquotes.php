<?php
/*
Plugin Name: Opus Primus PullQuotes
Plugin URI: http://opusprimus.com/
Description: Pull Quotes - An Opus Primus Stanza
Version: 1.0
Text Domain: opus-primus-pullquotes
Author: Edward Caissie
Author URI: http://edwardcaissie.com/
License: GNU General Public License v2
License URI: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/

/**
 * Opus Primus PullQuotes
 * An Opus Primus Stanza extracted from the Opus Primus theme version 1.3
 *
 * @package     OpusPrimusPullQuotes
 * @link        http://opusprimus.com/
 * @link        https://github.com/Cais/opus-primus-pullquotes/
 * @version     1.0
 * @author      Edward Caissie <edward.caissie@gmail.com>
 * @copyright   Copyright (c) 2014, Edward Caissie
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License version 2, as published by the
 * Free Software Foundation.
 *
 * You may NOT assume that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details
 *
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, write to:
 *
 *      Free Software Foundation, Inc.
 *      51 Franklin St, Fifth Floor
 *      Boston, MA  02110-1301  USA
 *
 * The license for this software can also likely be found here:
 * http://www.gnu.org/licenses/gpl-2.0.html
 *
 */
class OpusPrimusPullQuotes {

	/**
	 * Constructor
	 *
	 * @package     OpusPrimusPullQuotes
	 * @since       1.0
	 *
	 * @uses        __
	 * @uses        add_action
	 * @uses        add_shortcode
	 * @uses        plugin_dir_path
	 * @uses        plugin_dir_url
	 *
	 * @internal    Requires WordPress version 3.6 or later for use of shortcode optional filter
	 */
	function __construct() {

		/**
		 * WordPress version compatibility
		 * Check installed WordPress version for compatibility
		 */
		global $wp_version;
		$exit_message_version = __( 'Opus Primus PullQuotes requires WordPress version 3.6 or newer. <a href="http://codex.wordpress.org/Upgrading_WordPress">Please Update!</a>', 'opus-primus-pullquotes' );
		if ( version_compare( $wp_version, "3.6", "<" ) ) {
			exit ( $exit_message_version );
		}
		/** End if - version compare */

		/** Define some constants to save some keying */
		define( 'OPPQ_URL', plugin_dir_url( __FILE__ ) );
		define( 'OPPQ_PATH', plugin_dir_path( __FILE__ ) );

		/** Set Customization path and URL CONSTANTS with Sanity Checks */
		if ( ! defined( 'OPUS_CUSTOM_PATH' ) ) {
			define( 'OPUS_CUSTOM_PATH', WP_CONTENT_DIR . '/opus-primus-customs/' );
		}
		/** End if - not defined */
		if ( ! defined( 'OPUS_CUSTOM_URL' ) ) {
			define( 'OPUS_CUSTOM_URL', content_url( '/opus-primus-customs/' ) );
		}
		/** End if - not defined */

		/** Enqueue Scripts and Styles */
		add_action(
			'wp_enqueue_scripts', array(
				$this,
				'scripts_and_styles'
			)
		);

		/** Add Shortcode */
		add_shortcode( 'pullquote', array( $this, 'pull_quotes_shortcode' ) );

	}

	/** End function - constructor */


	/**
	 * Enqueue Scripts and Styles
	 * Use to enqueue the extension scripts and stylesheets, if they exists
	 *
	 * @package     OpusPrimusPullQuotes
	 * @since       1.0
	 *
	 * @uses        (CONSTANT) OPPQ_PATH
	 * @uses        (CONSTANT) OPUS_CUSTOM_PATH
	 * @uses        (CONSTANT) OPUS_CUSTOM_URL
	 * @uses        OpusPrimusPullQuotes::plugin_data
	 * @uses        wp_enqueue_script
	 * @uses        wp_enqueue_style
	 *
	 * @internal    jQuery is enqueued as a dependency
	 */
	function scripts_and_styles() {

		/** @var array $oppq_data - contains plugin data */
		$oppq_data = $this->plugin_data();

		/** Enqueue Scripts */
		/** Enqueue Opus Primus PullQuotes JavaScripts which will enqueue jQuery as a dependency */
		wp_enqueue_script( 'opus-primus-pullquote-js', OPPQ_PATH . 'opus-primus-pullquote.js', array( 'jquery' ), $oppq_data['Version'], true );

		/** Enqueue Styles */
		/** Enqueue PullQuotes Stanza Stylesheets */
		wp_enqueue_style( 'Opus-Primus-PullQuote-CSS', OPPQ_PATH . 'opus-primus-pullquote.css', array(), $oppq_data['Version'], 'screen' );

		/** This location is recommended as upgrade safe */
		if ( is_readable( OPUS_CUSTOM_PATH . 'opus-primus-pullquotes-custom.css' ) ) {
			wp_enqueue_style( 'BNSIA-Custom-Types', OPUS_CUSTOM_URL . 'opus-primus-pullquotes-custom.css', array(), $oppq_data['Version'], 'screen' );
		}
		/** End if - is readable */

	}

	/** End function - scripts and styles */


	/**
	 * PullQuotes Shortcode
	 *
	 * @package    OpusPrimusPullQuotes
	 * @since      1.0
	 *
	 * @uses       esc_html
	 * @uses       shortcode_atts
	 *
	 * @param      $atts
	 * @param null $content
	 *
	 * @return null|string
	 */
	function pull_quotes_shortcode( $atts, $content = null ) {

		/** If there is no content jump out immediately */
		if ( empty( $content ) ) {
			return null;
		}
		/** End if - empty content */

		shortcode_atts(
			array(
				'to'   => 'right',
				'by'   => '',
				'from' => '',
			),
			$atts, 'pullquote'
		);

		/** Sanity check - ensure "to" is set */
		if ( isset( $atts['to'] ) && ( 'left' == strtolower( $atts['to'] ) ) ) {
			$content = '<span class="pql">' . $content . '</span>';
		} else {
			$content = '<span class="pq">' . $content . '</span>';
		}
		/** End if - isset "to" and set to left */

		if ( isset( $atts['by'] ) ) {
			$content .= '<br />' . '<cite>' . esc_html( $atts['by'] ) . '</cite>';
		}
		/** End if - isset "by" */

		if ( isset( $atts['from'] ) ) {
			$content .= '<br />' . '<cite>' . esc_html( $atts['from'] ) . '</cite>';
		}

		/** End if - isset "from" */

		return $content;

	}
	/** End function - pull quotes shortcode */

	/**
	 * Plugin Data
	 * Returns the plugin header data as an array
	 *
	 * @package    OpusPrimusPullQuotes
	 * @since      1.0
	 *
	 * @uses       get_plugin_data
	 *
	 * @return array
	 */
	function plugin_data() {

		/** Call the wp-admin plugin code */
		require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
		/** @var $plugin_data - holds the plugin header data */
		$plugin_data = get_plugin_data( __FILE__ );

		return $plugin_data;

	}

	/** End function - plugin data */


}

/** End class - pull quotes */
new OpusPrimusPullQuotes();