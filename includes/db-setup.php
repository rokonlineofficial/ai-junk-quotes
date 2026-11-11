<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Creates or updates the wp_ai_quotes database table upon plugin activation.
 */
function ai_junk_quote_create_db_table() {
    global $wpdb;

    $table_name      = $wpdb->prefix . AI_JUNK_QUOTE_TABLE;
    $charset_collate = $wpdb->get_charset_collate();

    // SQL query using precise dbDelta formatting rules
    $sql = "CREATE TABLE $table_name (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        customer_name varchar(250) NOT NULL,
        customer_email varchar(250) NOT NULL,
        customer_phone varchar(50) NOT NULL,
        form_data longtext NOT NULL,
        image_urls longtext NOT NULL,
        ai_recommended_price decimal(10,2) DEFAULT NULL,
        ai_notes text DEFAULT NULL,
        final_approved_price decimal(10,2) DEFAULT NULL,
        status varchar(50) DEFAULT 'Pending' NOT NULL,
        created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    // Require WordPress upgrade functions for dbDelta
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta( $sql );

    // Store current DB version in wp_options
    add_option( 'ai_junk_quote_db_version', AI_JUNK_QUOTE_VERSION );
}