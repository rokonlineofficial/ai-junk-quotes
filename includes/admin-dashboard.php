<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register Admin Menu & Sub-menu Pages
 */
function ai_junk_quote_register_admin_menu() {
    add_menu_page(
        __( 'Junk Quotes', 'ai-junk-quote' ),
        __( 'Junk Quotes', 'ai-junk-quote' ),
        'manage_options',
        'ai-junk-quotes',
        'ai_junk_quote_admin_page_render',
        'dashicons-calculator',
        25
    );

    add_submenu_page(
        'ai-junk-quotes',
        __( 'All Quotes', 'ai-junk-quote' ),
        __( 'All Quotes', 'ai-junk-quote' ),
        'manage_options',
        'ai-junk-quotes',
        'ai_junk_quote_admin_page_render'
    );

    add_submenu_page(
        'ai-junk-quotes',
        __( 'Approved Quotes', 'ai-junk-quote' ),
        __( 'Approved', 'ai-junk-quote' ),
        'manage_options',
        'ai-junk-quotes-approved',
        'ai_junk_quote_admin_page_render'
    );

    add_submenu_page(
        'ai-junk-quotes',
        __( 'Pending Quotes', 'ai-junk-quote' ),
        __( 'Pending', 'ai-junk-quote' ),
        'manage_options',
        'ai-junk-quotes-pending',
        'ai_junk_quote_admin_page_render'
    );

    add_submenu_page(
        'ai-junk-quotes',
        __( 'Quote Settings', 'ai-junk-quote' ),
        __( 'Settings', 'ai-junk-quote' ),
        'manage_options',
        'ai-junk-quotes-settings',
        'ai_junk_quote_settings_page_render'
    );
}
add_action( 'admin_menu', 'ai_junk_quote_register_admin_menu' );

/**
 * Render Main Admin Dashboard Page (Quotes Table)
 */
function ai_junk_quote_admin_page_render() {
	// Show an individual lead detail page when requested.
if ( isset( $_GET['action'], $_GET['quote_id'] ) && 'view' === $_GET['action'] ) {
    $view_quote_id = intval( $_GET['quote_id'] );

    global $wpdb;
    $view_table_name = $wpdb->prefix . AI_JUNK_QUOTE_TABLE;

    $view_quote = $wpdb->get_row(
        $wpdb->prepare(
            "SELECT * FROM {$view_table_name} WHERE id = %d",
            $view_quote_id
        )
    );

    if ( ! $view_quote ) {
        wp_die( __( 'Quote not found.', 'ai-junk-quote' ) );
    }

    $view_form_data  = json_decode( $view_quote->form_data, true ) ?: array();
    $view_image_urls = json_decode( $view_quote->image_urls, true ) ?: array();

    ?>
    <div class="wrap ai-junk-admin-wrap">
        <p>
            <a href="<?php echo esc_url( admin_url( 'admin.php?page=ai-junk-quotes' ) ); ?>" class="button">
                &larr; Back to All Quotes
            </a>
        </p>

        <h1>Quote Request #<?php echo esc_html( $view_quote->id ); ?> — <?php echo esc_html( $view_quote->customer_name ); ?></h1>

        <div class="ai-junk-admin-card" style="margin-top:20px;">
            <h2>Customer Information</h2>

            <p><strong>Name:</strong> <?php echo esc_html( $view_quote->customer_name ); ?></p>

            <p>
                <strong>Email:</strong>
                <a href="mailto:<?php echo esc_attr( $view_quote->customer_email ); ?>">
                    <?php echo esc_html( $view_quote->customer_email ); ?>
                </a>
            </p>

            <p>
                <strong>Phone:</strong>
                <a href="tel:<?php echo esc_attr( $view_quote->customer_phone ); ?>">
                    <?php echo esc_html( $view_quote->customer_phone ); ?>
                </a>
            </p>

            <p><strong>ZIP Code:</strong> <?php echo esc_html( $view_form_data['zip'] ?? 'N/A' ); ?></p>

            <p><strong>Submitted:</strong> <?php echo esc_html( date( 'M j, Y g:i A', strtotime( $view_quote->created_at ) ) ); ?></p>
        </div>

        <div class="ai-junk-admin-card" style="margin-top:20px;">
            <h2>Job Details</h2>

            <?php foreach ( $view_form_data as $detail_key => $detail_value ) : ?>
                <?php
                if ( 'zip' === $detail_key || empty( $detail_value ) ) {
                    continue;
                }

                $detail_label = ucwords( str_replace( '_', ' ', $detail_key ) );

                if ( is_array( $detail_value ) ) {
                    $detail_value = implode( ', ', array_map( 'sanitize_text_field', $detail_value ) );
                }
                ?>

                <p>
                    <strong><?php echo esc_html( $detail_label ); ?>:</strong>
                    <?php echo nl2br( esc_html( (string) $detail_value ) ); ?>
                </p>
            <?php endforeach; ?>
        </div>

        <div class="ai-junk-admin-card" style="margin-top:20px;">
            <h2>Photos</h2>

            <?php if ( ! empty( $view_image_urls ) ) : ?>
                <div style="display:flex; flex-wrap:wrap; gap:12px;">
                    <?php foreach ( $view_image_urls as $view_img_url ) : ?>
                        <a href="<?php echo esc_url( $view_img_url ); ?>" target="_blank" rel="noopener">
                            <img
                                src="<?php echo esc_url( $view_img_url ); ?>"
                                alt="Customer uploaded photo"
                                style="width:160px; height:160px; object-fit:cover; border-radius:6px; display:block;"
                            >
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <p>No photos uploaded.</p>
            <?php endif; ?>
        </div>

        <div class="ai-junk-admin-card" style="margin-top:20px;">
            <h2>Quote Status</h2>

            <p><strong>Status:</strong> <?php echo esc_html( $view_quote->status ); ?></p>

            <p>
                <strong>Approved Price:</strong>
                <?php
                echo null !== $view_quote->final_approved_price && '' !== $view_quote->final_approved_price
                    ? '$' . esc_html( number_format( (float) $view_quote->final_approved_price, 2 ) )
                    : 'Not set';
                ?>
            </p>
        </div>
    </div>
    <?php

    return;
}
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( __( 'You do not have sufficient permissions to access this page.', 'ai-junk-quote' ) );
    }

    global $wpdb;
    $table_name     = $wpdb->prefix . AI_JUNK_QUOTE_TABLE;
    $notice_message = '';
    $notice_class   = 'notice-success';
    $current_page   = isset( $_GET['page'] ) ? sanitize_text_field( $_GET['page'] ) : 'ai-junk-quotes';

    // Handle Permanent Quote Deletion
    if ( isset( $_GET['action'], $_GET['quote_id'] ) && 'delete' === $_GET['action'] ) {
        $delete_id = intval( $_GET['quote_id'] );
        if ( ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( $_GET['_wpnonce'], 'ai_junk_delete_quote_' . $delete_id ) ) {
            wp_die( __( 'Security check failed.', 'ai-junk-quote' ) );
        }

        $deleted = $wpdb->delete(
            $table_name,
            array( 'id' => $delete_id ),
            array( '%d' )
        );

        if ( false !== $deleted ) {
            $notice_message = sprintf( __( 'Quote #%d was successfully deleted.', 'ai-junk-quote' ), $delete_id );
        } else {
            $notice_message = __( 'Failed to delete quote. Please try again.', 'ai-junk-quote' );
            $notice_class   = 'notice-error';
        }
    }

    // Handle Quote Update
    if ( isset( $_POST['ai_junk_update_quote'] ) ) {
        if ( ! isset( $_POST['ai_junk_admin_nonce'] ) || ! wp_verify_nonce( $_POST['ai_junk_admin_nonce'], 'ai_junk_update_quote_action' ) ) {
            wp_die( __( 'Security check failed.', 'ai-junk-quote' ) );
        }

        $quote_id    = intval( $_POST['quote_id'] );
        $final_price = ( isset( $_POST['final_approved_price'] ) && '' !== $_POST['final_approved_price'] ) ? floatval( $_POST['final_approved_price'] ) : null;
        $status      = isset( $_POST['status'] ) ? sanitize_text_field( $_POST['status'] ) : 'Pending';

        $allowed_statuses = array( 'Pending', 'Approved', 'Booked' );
        if ( ! in_array( $status, $allowed_statuses, true ) ) {
            $status = 'Pending';
        }

        $quote_row = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$table_name} WHERE id = %d", $quote_id ) );

        $updated = $wpdb->update(
            $table_name,
            array(
                'final_approved_price' => $final_price,
                'status'               => $status,
            ),
            array( 'id' => $quote_id ),
            array( '%f', '%s' ),
            array( '%d' )
        );

        if ( false !== $updated && $quote_row ) {
            ai_junk_quote_send_customer_status_email( $quote_row, $status, $final_price );
            $notice_message = __( 'Quote #' . $quote_id . ' updated successfully and notification email sent!', 'ai-junk-quote' );
        } else {
            $notice_message = __( 'Failed to update quote. Please try again.', 'ai-junk-quote' );
            $notice_class   = 'notice-error';
        }
    }

    $where_clause = '';
    $page_title   = __( 'All Quote Requests', 'ai-junk-quote' );

    if ( 'ai-junk-quotes-approved' === $current_page ) {
        $where_clause = " WHERE status = 'Approved' ";
        $page_title   = __( 'Approved Quotes', 'ai-junk-quote' );
    } elseif ( 'ai-junk-quotes-pending' === $current_page ) {
        $where_clause = " WHERE status = 'Pending' ";
        $page_title   = __( 'Pending Quotes', 'ai-junk-quote' );
    }

    $results = $wpdb->get_results( "SELECT * FROM {$table_name}{$where_clause} ORDER BY id DESC" );
    // Get excluded/test email addresses.
$test_emails = get_option( 'ai_junk_test_emails', array() );

if ( ! is_array( $test_emails ) ) {
    $test_emails = array();
}

$test_emails = array_map(
    function( $email ) {
        return strtolower( trim( $email ) );
    },
    $test_emails
);

// Load all submissions for lead tracking.
$all_quotes = $wpdb->get_results( "SELECT * FROM {$table_name} ORDER BY id DESC" );

$real_email_counts = array();
	$real_submissions = array();
$test_submissions = array();

foreach ( $all_quotes as $quote ) {
    $quote_email = strtolower( trim( $quote->customer_email ) );

    if ( in_array( $quote_email, $test_emails, true ) ) {
        $test_submissions[] = $quote;
    } else {
        $real_submissions[] = $quote;
		if ( ! empty( $quote_email ) ) {
    $real_email_counts[ $quote_email ] = isset( $real_email_counts[ $quote_email ] )
        ? $real_email_counts[ $quote_email ] + 1
        : 1;
}
    }
}

?>

    <div class="wrap ai-junk-admin-wrap">
        <h1 class="wp-heading-inline"><?php echo esc_html( $page_title ); ?></h1>
        <hr class="wp-header-end">

        <?php if ( ! empty( $notice_message ) ) : ?>
            <div class="notice <?php echo esc_attr( $notice_class ); ?> is-dismissible">
                <p><strong><?php echo esc_html( $notice_message ); ?></strong></p>
            </div>
        <?php endif; ?>

        <div class="ai-junk-admin-card">
            <h2><?php echo esc_html( $page_title ); ?></h2>
            <p><?php _e( 'Review customer submissions, inspect uploaded photos, and set final prices manually.', 'ai-junk-quote' ); ?></p>
			<div style="display:flex; flex-wrap:wrap; gap:12px; margin:18px 0;">

    <div style="background:#fff; border:1px solid #dcdcde; border-radius:6px; padding:14px 18px; min-width:150px;">
        <div style="font-size:12px; color:#646970;">Unique Real Leads</div>
        <div style="font-size:26px; font-weight:700;"><?php echo esc_html( count( $real_email_counts ) ); ?></div>
    </div>

    <div style="background:#fff; border:1px solid #dcdcde; border-radius:6px; padding:14px 18px; min-width:150px;">
        <div style="font-size:12px; color:#646970;">Real Submissions</div>
        <div style="font-size:26px; font-weight:700;"><?php echo esc_html( count( $real_submissions ) ); ?></div>
    </div>

    <div style="background:#fff; border:1px solid #dcdcde; border-radius:6px; padding:14px 18px; min-width:150px;">
        <div style="font-size:12px; color:#646970;">Test / Excluded</div>
        <div style="font-size:26px; font-weight:700;"><?php echo esc_html( count( $test_submissions ) ); ?></div>
    </div>

</div>

            <?php if ( empty( $results ) ) : ?>
                <div class="notice notice-info inline" style="margin-top:20px;">
                    <p><?php _e( 'No quotes found in this view.', 'ai-junk-quote' ); ?></p>
                </div>
            <?php else : ?>
                <div style="overflow-x: auto;">
                    <table class="ai-junk-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Customer Info</th>
                                <th>Job Details</th>
                                <th>Photos</th>
                                <th>Price & Status</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ( $results as $row ) : 
                                $form_data  = json_decode( $row->form_data, true ) ?: array();
                                $image_urls = json_decode( $row->image_urls, true ) ?: array();
                                $status     = $row->status;

                                $badge_class = 'ai-junk-badge-pending';
                                $row_class   = '';

                                if ( 'Approved' === $status ) {
                                    $badge_class = 'ai-junk-badge-approved';
                                    $row_class   = 'ai-junk-row-approved';
                                } elseif ( 'Booked' === $status ) {
                                    $badge_class = 'ai-junk-badge-booked';
                                }
$view_url = add_query_arg(
    array(
        'page'     => 'ai-junk-quotes',
        'action'   => 'view',
        'quote_id' => $row->id,
    ),
    admin_url( 'admin.php' )
);
                                $delete_url = wp_nonce_url(
                                    add_query_arg(
                                        array(
                                            'page'     => $current_page,
                                            'action'   => 'delete',
                                            'quote_id' => $row->id,
                                        ),
                                        admin_url( 'admin.php' )
                                    ),
                                    'ai_junk_delete_quote_' . $row->id
                                );
                            ?>
                                <tr class="<?php echo esc_attr( $row_class ); ?>">
                                    <td><strong>#<?php echo esc_html( $row->id ); ?></strong></td>
                                    <td>
                                        <strong><?php echo esc_html( $row->customer_name ); ?></strong><br>
                                        <a href="mailto:<?php echo esc_attr( $row->customer_email ); ?>"><?php echo esc_html( $row->customer_email ); ?></a><br>
                                        <a href="tel:<?php echo esc_attr( $row->customer_phone ); ?>"><?php echo esc_html( $row->customer_phone ); ?></a><br>
                                        <small>ZIP: <?php echo esc_html( $form_data['zip'] ?? 'N/A' ); ?></small>
                                    </td>
                                    <td style="max-width: 200px;">
                                        <strong>Service:</strong> <?php echo esc_html( ucfirst( $form_data['job_type'] ?? 'N/A' ) ); ?><br>
                                        <strong>Access:</strong> <?php echo esc_html( ucfirst( $form_data['access'] ?? 'N/A' ) ); ?><br>
                                        <?php if ( ! empty( $form_data['preferred_date'] ) ) : ?>
                                            <strong>Date:</strong> <?php echo esc_html( $form_data['preferred_date'] ); ?><br>
                                        <?php endif; ?>
                                        <?php if ( ! empty( $form_data['description'] ) ) : ?>
                                            <small><em>"<?php echo esc_html( wp_trim_words( $form_data['description'], 10 ) ); ?>"</em></small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ( ! empty( $image_urls ) ) : ?>
                                            <div class="ai-junk-thumb-grid">
                                                <?php foreach ( $image_urls as $img_url ) : ?>
                                                    <a href="<?php echo esc_url( $img_url ); ?>" target="_blank" title="View Full Image">
                                                        <img src="<?php echo esc_url( $img_url ); ?>" alt="Photo" style="width:100px; height:100px; object-fit:cover; border-radius:6px; display:block;">
                                                    </a>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php else : ?>
                                            <span style="color:#888; font-size:12px;">No Photos</span>
                                        <?php endif; ?>
                                    </td>

                                    <form method="post" action="">
                                        <?php wp_nonce_field( 'ai_junk_update_quote_action', 'ai_junk_admin_nonce' ); ?>
                                        <input type="hidden" name="quote_id" value="<?php echo esc_attr( $row->id ); ?>">
                                        
                                        <td style="min-width: 140px;">
                                            <div style="margin-bottom: 6px;">
                                                <span class="ai-junk-badge <?php echo esc_attr( $badge_class ); ?>">
                                                    <?php echo esc_html( $status ); ?>
                                                </span>
                                            </div>
                                            <label style="font-size: 11px; font-weight:600; display:block; margin-bottom: 2px;">Price ($):</label>
                                            <input type="number" step="0.01" name="final_approved_price" value="<?php echo esc_attr( $row->final_approved_price ); ?>" placeholder="0.00" style="width: 100%;">
                                            
                                            <label style="font-size: 11px; font-weight:600; display:block; margin-top: 6px; margin-bottom: 2px;">Status:</label>
                                            <select name="status" style="width: 100%;">
                                                <option value="Pending" <?php selected( $status, 'Pending' ); ?>>Pending</option>
                                                <option value="Approved" <?php selected( $status, 'Approved' ); ?>>Approved</option>
                                                <option value="Booked" <?php selected( $status, 'Booked' ); ?>>Booked</option>
                                            </select>
                                        </td>
                                        <td>
                                            <small><?php echo esc_html( date( 'M j, Y', strtotime( $row->created_at ) ) ); ?></small>
                                        </td>
                                        <td style="white-space: nowrap;">
                                            <div style="display: flex; gap: 6px; align-items: center;">
												<a href="<?php echo esc_url( $view_url ); ?>"
   class="button button-secondary button-small"
   style="height:32px; line-height:30px; padding:0 10px; text-decoration:none;">
    <?php _e( 'View', 'ai-junk-quote' ); ?>
</a>
                                                <button type="submit" name="ai_junk_update_quote" class="button button-primary button-small" style="height: 32px; line-height: 30px; padding: 0 10px;">
                                                    <?php _e( 'Save', 'ai-junk-quote' ); ?>
                                                </button>
                                                <a href="<?php echo esc_url( $delete_url ); ?>" 
                                                   class="button button-secondary button-small" 
                                                   style="color: #b32d2e; border-color: #e5a5a5; height: 32px; line-height: 30px; padding: 0 8px; text-decoration: none;"
                                                   onclick="return confirm('<?php echo esc_js( sprintf( __( 'Are you sure you want to permanently delete Quote #%d?', 'ai-junk-quote' ), $row->id ) ); ?>');">
                                                    <?php _e( 'Delete', 'ai-junk-quote' ); ?>
                                                </a>
                                            </div>
                                        </td>
                                    </form>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php
}

/**
 * Render Settings Admin Page
 */
function ai_junk_quote_settings_page_render() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( __( 'You do not have sufficient permissions to access this page.', 'ai-junk-quote' ) );
    }

    $notice_message = '';

    if ( isset( $_POST['ai_junk_save_settings'] ) ) {
        if ( ! isset( $_POST['ai_junk_settings_nonce'] ) || ! wp_verify_nonce( $_POST['ai_junk_settings_nonce'], 'ai_junk_save_settings_action' ) ) {
            wp_die( __( 'Security check failed.', 'ai-junk-quote' ) );
        }

        // Support multiple comma-separated emails
        $raw_emails   = isset( $_POST['ai_junk_admin_email'] ) ? sanitize_text_field( $_POST['ai_junk_admin_email'] ) : '';
        $email_parts  = array_filter( array_map( 'trim', explode( ',', $raw_emails ) ) );
        $valid_emails = array();

        foreach ( $email_parts as $email_item ) {
            $sanitized = sanitize_email( $email_item );
            if ( is_email( $sanitized ) ) {
                $valid_emails[] = $sanitized;
            }
        }

       $admin_email  = implode( ', ', $valid_emails );
$thankyou_url = isset( $_POST['ai_junk_thankyou_url'] ) ? esc_url_raw( $_POST['ai_junk_thankyou_url'] ) : '';

$raw_test_emails = isset( $_POST['ai_junk_test_emails'] )
    ? sanitize_textarea_field( $_POST['ai_junk_test_emails'] )
    : '';

$test_email_parts = preg_split( '/[\r\n,]+/', $raw_test_emails );
$valid_test_emails = array();

foreach ( $test_email_parts as $test_email ) {
    $test_email = sanitize_email( trim( $test_email ) );

    if ( is_email( $test_email ) ) {
        $valid_test_emails[] = strtolower( $test_email );
    }
}

$valid_test_emails = array_unique( $valid_test_emails );

update_option( 'ai_junk_admin_email', $admin_email );
update_option( 'ai_junk_thankyou_url', $thankyou_url );
update_option( 'ai_junk_test_emails', $valid_test_emails );

        $notice_message = __( 'Settings saved successfully!', 'ai-junk-quote' );
    }

    $current_admin_email  = get_option( 'ai_junk_admin_email', get_option( 'admin_email' ) );
    $current_thankyou_url = get_option( 'ai_junk_thankyou_url', '' );
    
	$current_test_emails = get_option(
    'ai_junk_test_emails',
    array(
        'info@junkrobbers.com',
        'ryandrobel@gmail.com',
        'ryandrobel@protonmail.com',
        'stacypavich@gmail.com',
  		'email@rokonline.com',
        'info@rokonline.com.bd',
    )
);

if ( ! is_array( $current_test_emails ) ) {
    $current_test_emails = array();
}

$current_test_emails_text = implode( "\n", $current_test_emails );
?>
    <div class="wrap ai-junk-admin-wrap">
        <h1 class="wp-heading-inline"><?php _e( 'Quote System Settings', 'ai-junk-quote' ); ?></h1>
        <hr class="wp-header-end">

        <?php if ( ! empty( $notice_message ) ) : ?>
            <div class="notice notice-success is-dismissible">
                <p><strong><?php echo esc_html( $notice_message ); ?></strong></p>
            </div>
        <?php endif; ?>

        <div class="ai-junk-admin-card" style="max-width: 700px;">
            <h2><?php _e( 'General Configuration', 'ai-junk-quote' ); ?></h2>
            <form method="post" action="">
                <?php wp_nonce_field( 'ai_junk_save_settings_action', 'ai_junk_settings_nonce' ); ?>

                <table class="form-table" role="presentation">
                    <tbody>
                        <tr>
                            <th scope="row">
                                <label><?php _e( 'Quote Form Shortcode', 'ai-junk-quote' ); ?></label>
                            </th>
                            <td>
                                <code style="font-size: 14px; padding: 6px 12px; background: #eef2f7; border: 1px solid #c3c4c7; border-radius: 4px; display: inline-block; font-weight: bold; color: #1d2327; user-select: all;">[ai_junk_quote_form]</code>
                                <p class="description"><?php _e( 'Copy and paste this shortcode into any page or Elementor widget.', 'ai-junk-quote' ); ?></p>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <label for="ai_junk_admin_email"><?php _e( 'Admin Notification Email(s)', 'ai-junk-quote' ); ?></label>
                            </th>
                            <td>
                                <input type="text" id="ai_junk_admin_email" name="ai_junk_admin_email" value="<?php echo esc_attr( $current_admin_email ); ?>" class="regular-text" placeholder="e.g. info@junkrobbers.com, quotes@junkrobbers.com" required>
                                <p class="description"><?php _e( 'Enter one or more email addresses separated by commas. Notifications will be sent to all addresses.', 'ai-junk-quote' ); ?></p>
                            </td>
                        </tr>
<tr>
    <th scope="row">
        <label for="ai_junk_test_emails"><?php _e( 'Test / Excluded Lead Emails', 'ai-junk-quote' ); ?></label>
    </th>
    <td>
        <textarea id="ai_junk_test_emails" name="ai_junk_test_emails" rows="6" class="large-text"><?php echo esc_textarea( $current_test_emails_text ); ?></textarea>
        <p class="description"><?php _e( 'One email per line (or comma-separated). Submissions from these addresses remain stored but are excluded from real lead reporting.', 'ai-junk-quote' ); ?></p>
    </td>
</tr>
                        <tr>
                            <th scope="row">
                                <label for="ai_junk_thankyou_url"><?php _e( 'Thank You Page URL (Optional)', 'ai-junk-quote' ); ?></label>
                            </th>
                            <td>
                                <input type="url" id="ai_junk_thankyou_url" name="ai_junk_thankyou_url" value="<?php echo esc_attr( $current_thankyou_url ); ?>" class="regular-text" placeholder="https://example.com/thank-you">
                            </td>
                        </tr>
                    </tbody>
                </table>

                <p class="submit">
                    <button type="submit" name="ai_junk_save_settings" class="button button-primary"><?php _e( 'Save Settings', 'ai-junk-quote' ); ?></button>
                </p>
            </form>
        </div>
    </div>
    <?php
}

/**
 * Automated Customer Email Notification Function on Status Updates
 */
function ai_junk_quote_send_customer_status_email( $quote_row, $status, $final_price ) {
    $customer_email = $quote_row->customer_email;
    $customer_name  = $quote_row->customer_name;
    $quote_id       = $quote_row->id;
    $form_data      = json_decode( $quote_row->form_data, true ) ?: array();
    $site_name      = get_bloginfo( 'name' );

    $subject       = sprintf( 'Update on Your Quote Request #%d - %s', $quote_id, $site_name );
    $price_display = ( null !== $final_price && '' !== $final_price ) ? '$' . number_format( (float) $final_price, 2 ) : 'Pending Review';

    $message = '
    <html>
    <head><title>Quote Status Update</title></head>
    <body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6;">
        <div style="max-width: 600px; margin: 0 auto; border: 1px solid #e2e2e2; padding: 25px; border-radius: 8px;">
            <h2 style="color: #3d2a6d; margin-top: 0;">Quote Status Update</h2>
            <p>Hello <strong>' . esc_html( $customer_name ) . '</strong>,</p>
            <p>We have an update regarding your quote request <strong>#' . esc_html( $quote_id ) . '</strong>.</p>
            
            <div style="background-color: #f8f9fa; padding: 16px; border-radius: 6px; margin: 20px 0; border-left: 4px solid #3d2a6d;">
                <p style="margin: 0 0 8px 0;"><strong>Current Status:</strong> <span style="color: #3d2a6d; font-weight: bold;">' . esc_html( $status ) . '</span></p>
                <p style="margin: 0;"><strong>Approved Price:</strong> <span style="color: #1a9b52; font-weight: bold; font-size: 18px;">' . esc_html( $price_display ) . '</span></p>
            </div>

            <p><strong>Job Details Recap:</strong></p>
            <ul>
                <li><strong>Service Type:</strong> ' . esc_html( ucfirst( $form_data['job_type'] ?? 'N/A' ) ) . '</li>
                <li><strong>Access Location:</strong> ' . esc_html( ucfirst( $form_data['access'] ?? 'N/A' ) ) . '</li>
                <li><strong>ZIP Code:</strong> ' . esc_html( $form_data['zip'] ?? 'N/A' ) . '</li>
            </ul>

            <p>If you have any questions or are ready to schedule, please reply directly to this email.</p>
            <hr style="border: none; border-top: 1px solid #eee; margin: 20px 0;">
            <p style="font-size: 12px; color: #777;">Sent by ' . esc_html( $site_name ) . '.</p>
        </div>
    </body>
    </html>';

    $headers = array( 'Content-Type: text/html; charset=UTF-8' );

    wp_mail( $customer_email, $subject, $message, $headers );
}