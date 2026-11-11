<?php
/**
 * Plugin Name: Junk Removal Quote System
 * Description: A multi-step junk removal quote system with admin quote management and email notifications.
 * Version: 1.2.7
 * Author: Rok Online
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


/*
 * Plugin constants
 */
define( 'AI_JUNK_QUOTE_VERSION', '1.2.7' );

define(
    'AI_JUNK_QUOTE_PATH',
    plugin_dir_path( __FILE__ )
);

define(
    'AI_JUNK_QUOTE_URL',
    plugin_dir_url( __FILE__ )
);

define(
    'AI_JUNK_QUOTE_TABLE',
    'ai_junk_quotes'
);


/*
 * Load plugin files
 */
require_once AI_JUNK_QUOTE_PATH . 'includes/db-setup.php';

require_once AI_JUNK_QUOTE_PATH . 'includes/form-handler.php';

require_once AI_JUNK_QUOTE_PATH . 'includes/admin-dashboard.php';


/*
 * Run database setup when plugin is activated.
 */
register_activation_hook(
    __FILE__,
    'ai_junk_quote_create_db_table'
);


/*
 * Load frontend form assets.
 */
function ai_junk_quote_enqueue_assets() {

    /*
     * CSS
     */
    wp_enqueue_style(
        'ai-junk-quote-style',
        AI_JUNK_QUOTE_URL . 'assets/css/style.css',
        array(),
        AI_JUNK_QUOTE_VERSION
    );


    /*
     * JavaScript
     */
    wp_enqueue_script(
        'ai-junk-quote-script',
        AI_JUNK_QUOTE_URL . 'assets/js/script.js',
        array(),
        AI_JUNK_QUOTE_VERSION,
        true
    );


    /*
     * Information JavaScript needs to submit the form.
     */
    wp_localize_script(
        'ai-junk-quote-script',
        'aiJunkQuoteData',
        array(

            'ajax_url' =>
                admin_url( 'admin-ajax.php' ),

            'nonce' =>
                wp_create_nonce(
                    'ai_junk_quote_nonce'
                ),

            /*
             * Leave blank to use the built-in thank-you
             * message after a successful submission.
             */
            'thankyou_url' =>
                '',
        )
    );
}

add_action(
    'wp_enqueue_scripts',
    'ai_junk_quote_enqueue_assets'
);


/*
 * Shortcode:
 *
 * [ai_junk_quote_form]
 */
function ai_junk_quote_shortcode() {

    ob_start();

    ai_junk_quote_render_frontend_form();

    return ob_get_clean();
}

add_shortcode(
    'ai_junk_quote_form',
    'ai_junk_quote_shortcode'
);
