<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


/**
 * Render the frontend quote form.
 */
function ai_junk_quote_render_frontend_form() {
    ?>

    <div id="qf-root" class="qf-wrap">

        <!-- Progress -->
        <div class="qf-progress-label" id="qf-step-label">
            Step 1 of 3 - Location
        </div>

        <div class="qf-progress-track">
            <div class="qf-progress-fill" id="qf-progress-fill"></div>
        </div>


        <!-- =========================
             STEP 1
        ========================== -->
        <div class="qf-step" data-step="1">

            <h2 class="qf-title">Get a Quote in Minutes</h2>

            <p class="qf-subtitle">
                Enter your ZIP code to get started.
            </p>

            <hr class="qf-divider">

            <div class="qf-field">

                <label for="qf-zip">
                    ZIP Code <span class="qf-req">*</span>
                </label>

                <input
                    type="text"
                    id="qf-zip"
                    inputmode="numeric"
                    autocomplete="postal-code"
                    maxlength="5"
                    placeholder="e.g. 60614"
                >

                <div class="qf-error" id="qf-zip-error">
                    Please enter a valid 5-digit ZIP code.
                </div>

            </div>

            <button
                type="button"
                class="qf-btn qf-btn-primary"
                id="qf-step1-next"
            >
                GET STARTED →
            </button>

        </div>


        <!-- =========================
             STEP 2
        ========================== -->
        <div class="qf-step" data-step="2" style="display:none;">

            <h2 class="qf-title">
                Tell Us What Needs to Go
            </h2>

            <p class="qf-subtitle">
                Select what you need removed, tell us a little about the job,
                and add photos if you have them.
            </p>

            <hr class="qf-divider">


            <!-- Job Types -->
            <div class="qf-field" id="qf-job-types-field">

                <label>
                    What are you getting rid of?
                    <span class="qf-req">*</span>
                </label>

                <div class="qf-choice-grid">

                    <label class="qf-choice">
                        <input
                            type="checkbox"
                            name="qf-job-types"
                            value="furniture"
                        >
                        <span>Furniture</span>
                    </label>

                    <label class="qf-choice">
                        <input
                            type="checkbox"
                            name="qf-job-types"
                            value="mattress_box_spring"
                        >
                        <span>Mattress / Box Spring</span>
                    </label>

                    <label class="qf-choice">
                        <input
                            type="checkbox"
                            name="qf-job-types"
                            value="appliances"
                        >
                        <span>Appliances</span>
                    </label>

                    <label class="qf-choice">
                        <input
                            type="checkbox"
                            name="qf-job-types"
                            value="bed_bug_items"
                        >
                        <span>Bed Bug-Infested Items</span>
                    </label>

                    <label class="qf-choice">
                        <input
                            type="checkbox"
                            name="qf-job-types"
                            value="household_junk"
                        >
                        <span>Household Junk</span>
                    </label>

                    <label class="qf-choice">
                        <input
                            type="checkbox"
                            name="qf-job-types"
                            value="construction_heavy_debris"
                        >
                        <span>Construction / Heavy Debris</span>
                    </label>

                    <label class="qf-choice">
                        <input
                            type="checkbox"
                            name="qf-job-types"
                            value="yard_waste"
                        >
                        <span>Yard Waste</span>
                    </label>

                    <label class="qf-choice">
                        <input
                            type="checkbox"
                            name="qf-job-types"
                            value="cleanout"
                        >
                        <span>Full or Partial Cleanout</span>
                    </label>

                    <label class="qf-choice">
                        <input
                            type="checkbox"
                            name="qf-job-types"
                            value="other"
                        >
                        <span>Other</span>
                    </label>

                </div>

                <div class="qf-error" id="qf-job-types-error">
                    Please select at least one item type.
                </div>

            </div>


            <!-- Construction Conditional -->
            <div
                class="qf-field qf-conditional"
                id="qf-heavy-material-wrap"
                style="display:none;"
            >

                <label for="qf-heavy-material">
                    What type of heavy material is included?
                    <span class="qf-req">*</span>
                </label>

                <select id="qf-heavy-material">

                    <option value="">
                        Select an option...
                    </option>

                    <option value="none_not_sure">
                        No / Not Sure
                    </option>

                    <option value="concrete_brick_block">
                        Concrete / Brick / Block
                    </option>

                    <option value="dirt_soil">
                        Dirt / Soil
                    </option>

                    <option value="tile_plaster">
                        Tile / Plaster
                    </option>

                    <option value="other_heavy_material">
                        Other Heavy Material
                    </option>

                </select>

                <div class="qf-error" id="qf-heavy-material-error">
                    Please select the type of heavy material.
                </div>

            </div>


            <!-- Description -->
            <div class="qf-field">

                <label for="qf-description">
                    Tell us what needs to go
                </label>

                <textarea
                    id="qf-description"
                    rows="4"
                    placeholder="Example: sectional couch, queen mattress, dresser, TV and about 10 bags of household items."
                ></textarea>

            </div>


            <!-- Photos -->
            <div class="qf-field">

                <label>
                    Add Photos
                    <span class="qf-recommended">
                        (Recommended)
                    </span>
                </label>

                <p class="qf-field-help">
                    Photos are the fastest way for us to give you an accurate quote.
                </p>

                <div
                    class="qf-dropzone"
                    id="qf-dropzone"
                >

                    <span style="display:none;">
    Upload photos
</span>

                    <button
                        type="button"
                        class="qf-btn-select"
                        id="qf-select-files"
                    >
                        CHOOSE PHOTOS
                    </button>

                    <input
                        type="file"
                        id="qf-file-input"
                        multiple
                        accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                        style="display:none;"
                    >

                </div>

                <div class="qf-hint">
                    Up to 8 photos. Maximum 10 MB per photo.
                    JPG, PNG or WebP.
                </div>

                <div
                    class="qf-error"
                    id="qf-files-error"
                ></div>

                <div
                    class="qf-file-list"
                    id="qf-file-list"
                ></div>

            </div>


            <!-- Location -->
            <div class="qf-field">

                <label for="qf-access">
                    Where are the items located?
                    <span class="qf-req">*</span>
                </label>

                <select id="qf-access">

                    <option value="">
                        Select a location...
                    </option>

                    <option value="outside_curbside">
                        Outside / Curbside
                    </option>

                    <option value="garage_ground_level">
                        Garage / Ground Level
                    </option>

                    <option value="inside_ground_floor">
                        Inside - Ground Floor
                    </option>

                    <option value="upper_floor">
                        Upper Floor - Stairs or Elevator
                    </option>

                    <option value="basement">
                        Basement
                    </option>

                    <option value="other">
                        Other
                    </option>

                </select>

                <div class="qf-error" id="qf-access-error">
                    Please select where the items are located.
                </div>

            </div>


            <!-- Upper Floor Conditional -->
            <div
                id="qf-upper-floor-wrap"
                class="qf-conditional-group"
                style="display:none;"
            >

                <div class="qf-field">

                    <label for="qf-floor">
                        What floor?
                        <span class="qf-req">*</span>
                    </label>

                    <select id="qf-floor">

                        <option value="">
                            Select floor...
                        </option>

                        <option value="2nd">
                            2nd Floor
                        </option>

                        <option value="3rd">
                            3rd Floor
                        </option>

                        <option value="4th">
                            4th Floor
                        </option>

                        <option value="5th_plus">
                            5th Floor or Higher
                        </option>

                    </select>

                    <div class="qf-error" id="qf-floor-error">
                        Please select the floor.
                    </div>

                </div>


                <div class="qf-field">

                    <label for="qf-elevator">
                        Is there an elevator available for the removal?
                        <span class="qf-req">*</span>
                    </label>

                    <select id="qf-elevator">

                        <option value="">
                            Select an option...
                        </option>

                        <option value="yes">
                            Yes
                        </option>

                        <option value="no">
                            No
                        </option>

                    </select>

                    <div class="qf-error" id="qf-elevator-error">
                        Please tell us whether an elevator is available.
                    </div>

                </div>

            </div>


            <!-- Basement Conditional -->
            <div
                class="qf-field qf-conditional"
                id="qf-basement-wrap"
                style="display:none;"
            >

                <label for="qf-basement-access">
                    How is the basement accessed?
                    <span class="qf-req">*</span>
                </label>

                <select id="qf-basement-access">

                    <option value="">
                        Select access...
                    </option>

                    <option value="interior_stairs">
                        Interior Stairs
                    </option>

                    <option value="exterior_stairs">
                        Exterior Stairs
                    </option>

                    <option value="walkout_ground_level">
                        Walk-Out / Ground Level
                    </option>

                    <option value="both">
                        Both
                    </option>

                </select>

                <div class="qf-error" id="qf-basement-access-error">
                    Please select the basement access.
                </div>

            </div>


            <!-- Navigation -->
            <div class="qf-btn-row">

                <button
                    type="button"
                    class="qf-btn qf-btn-secondary"
                    id="qf-step2-back"
                >
                    Previous
                </button>

                <button
                    type="button"
                    class="qf-btn qf-btn-primary"
                    id="qf-step2-next"
                >
                    Next → Timing &amp; Contact
                </button>

            </div>

        </div>


        <!-- =========================
             STEP 3
        ========================== -->
        <div class="qf-step" data-step="3" style="display:none;">

            <h2 class="qf-title">
                When Would You Like It Gone?
            </h2>

            <p class="qf-subtitle">
                Choose a preferred date, or select ASAP for our earliest availability.
            </p>

            <hr class="qf-divider">


            <!-- Timing -->
            <div class="qf-field" id="qf-timing-field">

                <label>
                    Service Timing
                    <span class="qf-req">*</span>
                </label>

                <div class="qf-radio-stack">

                    <label class="qf-choice">

                        <input
                            type="radio"
                            name="qf-timing"
                            value="preferred_date"
                        >

                        <span>
                            Preferred Date
                        </span>

                    </label>

                    <label class="qf-choice">

                        <input
                            type="radio"
                            name="qf-timing"
                            value="asap"
                        >

                        <span>
                            ASAP / Earliest Available
                        </span>

                    </label>

                </div>

                <div class="qf-error" id="qf-timing-error">
                    Please select a service timing option.
                </div>

            </div>


            <!-- Date Conditional -->
            <div
                class="qf-field qf-conditional"
                id="qf-date-wrap"
                style="display:none;"
            >

                <label for="qf-date">
                    Preferred Date
                    <span class="qf-req">*</span>
                </label>

                <input
                    type="date"
                    id="qf-date"
                >

                <div class="qf-error" id="qf-date-error">
                    Please choose a valid service date.
                </div>

            </div>


            <!-- Contact -->
            <div class="qf-section-heading">

                <h3>
                    Your Contact Information
                </h3>

                <p>
                    Tell us how to reach you with your quote.
                </p>

            </div>


            <div class="qf-field">

                <label for="qf-name">
                    Name
                    <span class="qf-req">*</span>
                </label>

                <input
                    type="text"
                    id="qf-name"
                    autocomplete="name"
                    placeholder="Your name"
                >

                <div class="qf-error" id="qf-name-error">
                    Please enter your name.
                </div>

            </div>


            <div class="qf-field">

                <label for="qf-phone">
                    Mobile Number
                    <span class="qf-req">*</span>
                </label>

                <input
                    type="tel"
                    id="qf-phone"
                    autocomplete="tel"
                    placeholder="(312) 521-0935"
                >

                <div class="qf-error" id="qf-phone-error">
                    Please enter a valid phone number.
                </div>

            </div>


            <div class="qf-field">

                <label for="qf-email">
                    Email
                    <span class="qf-req">*</span>
                </label>

                <input
                    type="email"
                    id="qf-email"
                    autocomplete="email"
                    placeholder="email@example.com"
                >

                <div class="qf-error" id="qf-email-error">
                    Please enter a valid email address.
                </div>

            </div>


            <div class="qf-field">

                <label for="qf-notes">
                    Anything else you'd like us to know?
                </label>

                <textarea
                    id="qf-notes"
                    rows="3"
                    placeholder="Optional"
                ></textarea>

            </div>


            <div class="qf-checkbox-row">

                <input
                    type="checkbox"
                    id="qf-sms-consent"
                >

                <label for="qf-sms-consent">
                    I consent to receive SMS updates regarding my quote request.
                    Msg &amp; data rates may apply.
                </label>

            </div>


            <div class="qf-btn-row">

                <button
                    type="button"
                    class="qf-btn qf-btn-secondary"
                    id="qf-step3-back"
                >
                    Previous
                </button>

                <button
                    type="button"
                    class="qf-btn qf-btn-primary"
                    id="qf-submit-btn"
                >
                    GET MY FREE QUOTE
                </button>

            </div>

        </div>


        <!-- =========================
             THANK YOU
        ========================== -->
        <div
            class="qf-step"
            data-step="thankyou"
            style="display:none;"
        >

            <div class="qf-thankyou">

                <div class="qf-check">
                    ✓
                </div>

                <h2 class="qf-title qf-center">
                    Thanks! We've Received Your Quote Request.
                </h2>

                <p class="qf-subtitle qf-center">
                    We'll review the details and photos you submitted and get back
                    to you shortly with pricing or any questions needed to finalize
                    your quote.
                </p>

                <p class="qf-subtitle qf-center">
                    Need to add something? Call or text us at
                    (312) 521-0935.
                </p>

            </div>

        </div>

    </div>

    <?php
}


/**
 * Upload one quote photo without a multipart file field.
 *
 * Some hosting security layers terminate anonymous multipart requests that
 * contain files before WordPress can handle them. The quote form uploads each
 * image as validated base64 data first, then submits the returned local URL
 * with the lead. This also keeps the final lead request small and reliable.
 */
function ai_junk_quote_handle_photo_upload() {

    check_ajax_referer(
        'ai_junk_quote_nonce',
        'nonce'
    );

    $data = isset( $_POST['photoData'] )
        ? wp_unslash( $_POST['photoData'] )
        : '';

    $name = isset( $_POST['photoName'] )
        ? sanitize_file_name( wp_unslash( $_POST['photoName'] ) )
        : 'quote-photo';

    if (
        ! is_string( $data ) ||
        ! preg_match(
            '#^data:(image/(?:jpeg|png|webp));base64,([A-Za-z0-9+/=\r\n]+)$#',
            $data,
            $matches
        )
    ) {
        wp_send_json_error(
            array( 'message' => 'That photo could not be read. Please choose a JPG, PNG or WebP image.' )
        );
    }

    $binary = base64_decode( preg_replace( '/\s+/', '', $matches[2] ), true );

    if ( false === $binary || '' === $binary ) {
        wp_send_json_error(
            array( 'message' => 'That photo could not be read. Please choose it again.' )
        );
    }

    if ( strlen( $binary ) > 10 * 1024 * 1024 ) {
        wp_send_json_error(
            array( 'message' => 'Each photo must be 10 MB or smaller.' )
        );
    }

    $image_info = @getimagesizefromstring( $binary );
    $mime       = is_array( $image_info ) && ! empty( $image_info['mime'] )
        ? $image_info['mime']
        : '';

    $extensions = array(
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp',
    );

    if ( ! isset( $extensions[ $mime ] ) ) {
        wp_send_json_error(
            array( 'message' => 'Only JPG, PNG and WebP photos are allowed.' )
        );
    }

    $base_name = pathinfo( $name, PATHINFO_FILENAME );
    $base_name = sanitize_file_name( $base_name );
    $base_name = $base_name ? $base_name : 'quote-photo';
    $file_name = $base_name . '.' . $extensions[ $mime ];
    $upload    = wp_upload_bits( $file_name, null, $binary );

    if ( ! empty( $upload['error'] ) || empty( $upload['url'] ) ) {
        wp_send_json_error(
            array( 'message' => 'That photo could not be uploaded. Please try again.' )
        );
    }

    wp_send_json_success(
        array( 'url' => esc_url_raw( $upload['url'] ) )
    );
}


/**
 * Handle AJAX quote submission.
 */
function ai_junk_quote_handle_form_submission() {

    check_ajax_referer(
        'ai_junk_quote_nonce',
        'nonce'
    );


    // Contact details.
    $name = isset( $_POST['name'] )
        ? sanitize_text_field( wp_unslash( $_POST['name'] ) )
        : '';

    $email = isset( $_POST['email'] )
        ? sanitize_email( wp_unslash( $_POST['email'] ) )
        : '';

    $phone = isset( $_POST['phone'] )
        ? sanitize_text_field( wp_unslash( $_POST['phone'] ) )
        : '';

    $zip = isset( $_POST['zip'] )
        ? sanitize_text_field( wp_unslash( $_POST['zip'] ) )
        : '';


    if (
        strlen( $name ) < 2 ||
        ! is_email( $email ) ||
        strlen( preg_replace( '/\D+/', '', $phone ) ) < 7 ||
        ! preg_match( '/^\d{5}$/', $zip )
    ) {

        wp_send_json_error(
            array(
                'message' =>
                    'Please check your ZIP code and contact information.'
            )
        );
    }


    // Job types.
    $allowed_job_types = array(
        'furniture',
        'mattress_box_spring',
        'appliances',
        'bed_bug_items',
        'household_junk',
        'construction_heavy_debris',
        'yard_waste',
        'cleanout',
        'other',
    );

    $job_types = array();

if ( isset( $_POST['job_types'] ) && is_array( $_POST['job_types'] ) ) {

    foreach ( $_POST['job_types'] as $job_type ) {

        $job_type = sanitize_key( wp_unslash( $job_type ) );

        if ( in_array( $job_type, $allowed_job_types, true ) ) {
            $job_types[] = $job_type;
        }
    }
}

$job_types = array_values( array_unique( $job_types ) );
    if ( empty( $job_types ) ) {

        wp_send_json_error(
            array(
                'message' =>
                    'Please select at least one item type.'
            )
        );
    }


    // Location/access.
    $allowed_access = array(
        'outside_curbside',
        'garage_ground_level',
        'inside_ground_floor',
        'upper_floor',
        'basement',
        'other',
    );

    $access = isset( $_POST['access'] )
        ? sanitize_key( wp_unslash( $_POST['access'] ) )
        : '';

    if (
        ! in_array(
            $access,
            $allowed_access,
            true
        )
    ) {

        wp_send_json_error(
            array(
                'message' =>
                    'Please select where the items are located.'
            )
        );
    }


    // Conditional access details.
    $floor = '';
    $elevator = '';
    $basement_access = '';

    if ( 'upper_floor' === $access ) {

        $allowed_floors = array(
            '2nd',
            '3rd',
            '4th',
            '5th_plus',
        );

        $allowed_elevator = array(
            'yes',
            'no',
        );

        $floor = isset( $_POST['floor'] )
            ? sanitize_key( wp_unslash( $_POST['floor'] ) )
            : '';

        $elevator = isset( $_POST['elevator'] )
            ? sanitize_key( wp_unslash( $_POST['elevator'] ) )
            : '';

        if (
            ! in_array( $floor, $allowed_floors, true ) ||
            ! in_array( $elevator, $allowed_elevator, true )
        ) {

            wp_send_json_error(
                array(
                    'message' =>
                        'Please complete the upper-floor information.'
                )
            );
        }
    }


    if ( 'basement' === $access ) {

        $allowed_basement_access = array(
            'interior_stairs',
            'exterior_stairs',
            'walkout_ground_level',
            'both',
        );

        $basement_access =
            isset( $_POST['basementAccess'] )
            ? sanitize_key(
                wp_unslash(
                    $_POST['basementAccess']
                )
            )
            : '';

        if (
            ! in_array(
                $basement_access,
                $allowed_basement_access,
                true
            )
        ) {

            wp_send_json_error(
                array(
                    'message' =>
                        'Please tell us how the basement is accessed.'
                )
            );
        }
    }


    // Heavy material conditional.
    $heavy_material = '';

    if (
        in_array(
            'construction_heavy_debris',
            $job_types,
            true
        )
    ) {

        $allowed_heavy_materials = array(
            'none_not_sure',
            'concrete_brick_block',
            'dirt_soil',
            'tile_plaster',
            'other_heavy_material',
        );

        $heavy_material =
            isset( $_POST['heavyMaterial'] )
            ? sanitize_key(
                wp_unslash(
                    $_POST['heavyMaterial']
                )
            )
            : '';

        if (
            ! in_array(
                $heavy_material,
                $allowed_heavy_materials,
                true
            )
        ) {

            wp_send_json_error(
                array(
                    'message' =>
                        'Please select the type of heavy material.'
                )
            );
        }
    }


    // Description / notes.
    $description =
        isset( $_POST['description'] )
        ? sanitize_textarea_field(
            wp_unslash(
                $_POST['description']
            )
        )
        : '';

    $notes =
        isset( $_POST['notes'] )
        ? sanitize_textarea_field(
            wp_unslash(
                $_POST['notes']
            )
        )
        : '';


    // Timing.
    $timing =
        isset( $_POST['timing'] )
        ? sanitize_key(
            wp_unslash(
                $_POST['timing']
            )
        )
        : '';

    if (
        ! in_array(
            $timing,
            array(
                'preferred_date',
                'asap',
            ),
            true
        )
    ) {

        wp_send_json_error(
            array(
                'message' =>
                    'Please select when you would like the items removed.'
            )
        );
    }


    $preferred_date = '';

    if ( 'preferred_date' === $timing ) {

        $preferred_date =
            isset( $_POST['preferredDate'] )
            ? sanitize_text_field(
                wp_unslash(
                    $_POST['preferredDate']
                )
            )
            : '';

        $date_object =
            DateTime::createFromFormat(
                'Y-m-d',
                $preferred_date
            );

        $today = current_time( 'Y-m-d' );

        if (
            ! $date_object ||
            $date_object->format( 'Y-m-d' )
                !== $preferred_date ||
            $preferred_date < $today
        ) {

            wp_send_json_error(
                array(
                    'message' =>
                        'Please choose a valid preferred service date.'
                )
            );
        }
    }


    $sms_consent =
        (
            isset( $_POST['smsConsent'] ) &&
            'true' === sanitize_text_field(
                wp_unslash(
                    $_POST['smsConsent']
                )
            )
        )
        ? 'Yes'
        : 'No';


    // Friendly labels.
    $job_labels = array(
        'furniture' =>
            'Furniture',

        'mattress_box_spring' =>
            'Mattress / Box Spring',

        'appliances' =>
            'Appliances',

        'bed_bug_items' =>
            'Bed Bug-Infested Items',

        'household_junk' =>
            'Household Junk',

        'construction_heavy_debris' =>
            'Construction / Heavy Debris',

        'yard_waste' =>
            'Yard Waste',

        'cleanout' =>
            'Full or Partial Cleanout',

        'other' =>
            'Other',
    );


    $access_labels = array(
        'outside_curbside' =>
            'Outside / Curbside',

        'garage_ground_level' =>
            'Garage / Ground Level',

        'inside_ground_floor' =>
            'Inside - Ground Floor',

        'upper_floor' =>
            'Upper Floor - Stairs or Elevator',

        'basement' =>
            'Basement',

        'other' =>
            'Other',
    );


    $floor_labels = array(
        '2nd' =>
            '2nd Floor',

        '3rd' =>
            '3rd Floor',

        '4th' =>
            '4th Floor',

        '5th_plus' =>
            '5th Floor or Higher',
    );


    $basement_labels = array(
        'interior_stairs' =>
            'Interior Stairs',

        'exterior_stairs' =>
            'Exterior Stairs',

        'walkout_ground_level' =>
            'Walk-Out / Ground Level',

        'both' =>
            'Both',
    );


    $heavy_labels = array(
        'none_not_sure' =>
            'No / Not Sure',

        'concrete_brick_block' =>
            'Concrete / Brick / Block',

        'dirt_soil' =>
            'Dirt / Soil',

        'tile_plaster' =>
            'Tile / Plaster',

        'other_heavy_material' =>
            'Other Heavy Material',
    );


    $job_type_labels = array();

    foreach ( $job_types as $job_type ) {

        if (
            isset(
                $job_labels[
                    $job_type
                ]
            )
        ) {

            $job_type_labels[] =
                $job_labels[
                    $job_type
                ];
        }
    }


    // Save form answers.
    $form_data = array(

        'zip' =>
            $zip,

        // Legacy field retained for compatibility.
        'job_type' =>
            implode(
                ', ',
                $job_type_labels
            ),

        'job_types' =>
            $job_types,

        'job_type_labels' =>
            $job_type_labels,

        'access' =>
            $access,

        'access_label' =>
            $access_labels[
                $access
            ],

        'floor' =>
            $floor,

        'floor_label' =>
            (
                $floor &&
                isset(
                    $floor_labels[
                        $floor
                    ]
                )
            )
            ? $floor_labels[
                $floor
            ]
            : '',

        'elevator' =>
            $elevator,

        'basement_access' =>
            $basement_access,

        'basement_access_label' =>
            (
                $basement_access &&
                isset(
                    $basement_labels[
                        $basement_access
                    ]
                )
            )
            ? $basement_labels[
                $basement_access
            ]
            : '',

        'heavy_material' =>
            $heavy_material,

        'heavy_material_label' =>
            (
                $heavy_material &&
                isset(
                    $heavy_labels[
                        $heavy_material
                    ]
                )
            )
            ? $heavy_labels[
                $heavy_material
            ]
            : '',

        'description' =>
            $description,

        'timing' =>
            $timing,

        'preferred_date' =>
            $preferred_date,

        'notes' =>
            $notes,

        'sms_consent' =>
            $sms_consent,
    );


    /**
     * Photo uploads.
     */
    $uploaded_image_urls = array();

    if ( isset( $_POST['uploadedPhotoUrls'] ) && is_array( $_POST['uploadedPhotoUrls'] ) ) {

        $uploads = wp_get_upload_dir();
        $baseurl = trailingslashit( $uploads['baseurl'] );

        foreach ( array_slice( $_POST['uploadedPhotoUrls'], 0, 20 ) as $photo_url ) {
            $photo_url = esc_url_raw( wp_unslash( $photo_url ) );

            if ( $photo_url && 0 === strpos( $photo_url, $baseurl ) ) {
                $uploaded_image_urls[] = $photo_url;
            }
        }
    }

    if (
        ! empty(
            $_FILES['files']
        )
    ) {

        require_once
            ABSPATH .
            'wp-admin/includes/file.php';

        $files =
            $_FILES['files'];

        if (
            is_array(
                $files['name']
            )
        ) {

            $file_count =
                count(
                    $files['name']
                );

            if (
                $file_count + count( $uploaded_image_urls ) > 20
            ) {

                wp_send_json_error(
                    array(
                        'message' =>
                            'Please upload no more than 20 photos.'
                    )
                );
            }


            $allowed_mimes = array(
                'jpg|jpeg|jpe' =>
                    'image/jpeg',

                'png' =>
                    'image/png',

                'webp' =>
                    'image/webp',
            );


            foreach (
                $files['name']
                as $key => $value
            ) {

                if (
                    empty(
                        $files['name'][
                            $key
                        ]
                    )
                ) {
                    continue;
                }


                if (
                    UPLOAD_ERR_OK !==
                    (int)
                    $files['error'][
                        $key
                    ]
                ) {

                    wp_send_json_error(
                        array(
                            'message' =>
                                'One of the photos could not be uploaded. Please try again.'
                        )
                    );
                }


                if (
                    (int)
                    $files['size'][
                        $key
                    ] >
                    10 * 1024 * 1024
                ) {

                    wp_send_json_error(
                        array(
                            'message' =>
                                'Each photo must be 10 MB or smaller.'
                        )
                    );
                }


                $file = array(

                    'name' =>
                        sanitize_file_name(
                            $files['name'][
                                $key
                            ]
                        ),

                    'type' =>
                        $files['type'][
                            $key
                        ],

                    'tmp_name' =>
                        $files['tmp_name'][
                            $key
                        ],

                    'error' =>
                        $files['error'][
                            $key
                        ],

                    'size' =>
                        $files['size'][
                            $key
                        ],
                );


                $file_check =
                    wp_check_filetype_and_ext(
                        $file['tmp_name'],
                        $file['name'],
                        $allowed_mimes
                    );


                if (
                    empty(
                        $file_check['type']
                    ) ||
                    ! in_array(
                        $file_check['type'],
                        array(
                            'image/jpeg',
                            'image/png',
                            'image/webp',
                        ),
                        true
                    )
                ) {

                    wp_send_json_error(
                        array(
                            'message' =>
                                'Only JPG, PNG and WebP photos are allowed.'
                        )
                    );
                }


                $movefile =
                    wp_handle_upload(
                        $file,
                        array(
                            'test_form' =>
                                false,

                            'mimes' =>
                                $allowed_mimes,
                        )
                    );


                if (
                    ! $movefile ||
                    isset(
                        $movefile['error']
                    )
                ) {

                    wp_send_json_error(
                        array(
                            'message' =>
                                'A photo could not be uploaded. Please try again.'
                        )
                    );
                }


                $uploaded_image_urls[] =
                    esc_url_raw(
                        $movefile['url']
                    );
            }
        }
    }


    /**
     * Save to existing database table.
     */
    global $wpdb;

    $table_name =
        $wpdb->prefix .
        AI_JUNK_QUOTE_TABLE;


    $inserted =
        $wpdb->insert(

            $table_name,

            array(

                'customer_name' =>
                    $name,

                'customer_email' =>
                    $email,

                'customer_phone' =>
                    $phone,

                'form_data' =>
                    wp_json_encode(
                        $form_data
                    ),

                'image_urls' =>
                    wp_json_encode(
                        $uploaded_image_urls
                    ),

                'ai_recommended_price' =>
                    null,

                'ai_notes' =>
                    'Pending manual review.',

                'final_approved_price' =>
                    null,

                'status' =>
                    'Pending',

                'created_at' =>
                    current_time(
                        'mysql'
                    ),
            )
        );


   if ( false === $inserted ) {

    wp_send_json_error(
        array(
            'message' => 'Database error: ' . $wpdb->last_error
        )
    );
}


    $quote_id =
        $wpdb->insert_id;


    /**
     * Admin email.
     */
    $admin_email_setting =
        get_option(
            'ai_junk_admin_email',
            'info@junkrobbers.com'
        );


    $admin_emails =
        array_filter(
            array_map(
                'trim',
                explode(
                    ',',
                    $admin_email_setting
                )
            )
        );


    if (
        empty(
            $admin_emails
        )
    ) {

        $admin_emails = array(
            'info@junkrobbers.com'
        );
    }


    $subject =
        'New Junk Removal Quote - ' .
        $name .
        ' - ' .
        $zip;


    $images_html =
        '<em>No photos uploaded</em>';


    if (
        ! empty(
            $uploaded_image_urls
        )
    ) {

        $images_html =
            '<ul>';

        foreach (
            $uploaded_image_urls
            as $img_url
        ) {

            $images_html .=
                '<li><a href="' .
                esc_url(
                    $img_url
                ) .
                '" target="_blank">' .
                esc_html(
                    $img_url
                ) .
                '</a></li>';
        }

        $images_html .=
            '</ul>';
    }


    $timing_display =
        (
            'asap' ===
            $timing
        )
        ? 'As soon as possible'
        : 'Preferred Date';


    $conditional_html = '';


    if (
        'upper_floor' ===
        $access
    ) {

        $conditional_html .=
            '<li><strong>Floor:</strong> ' .
            esc_html(
                $floor_labels[
                    $floor
                ]
            ) .
            '</li>';

        $conditional_html .=
            '<li><strong>Elevator:</strong> ' .
            (
                'yes' ===
                $elevator
                ? 'Yes'
                : 'No'
            ) .
            '</li>';
    }


    if (
        'basement' ===
        $access
    ) {

        $conditional_html .=
            '<li><strong>Basement Access:</strong> ' .
            esc_html(
                $basement_labels[
                    $basement_access
                ]
            ) .
            '</li>';
    }


    if (
        in_array(
            'construction_heavy_debris',
            $job_types,
            true
        )
    ) {

        $conditional_html .=
            '<li><strong>Heavy Material:</strong> ' .
            esc_html(
                $heavy_labels[
                    $heavy_material
                ]
            ) .
            '</li>';
    }


    $message = '
    <html>
    <body style="font-family:Arial,sans-serif;color:#333;line-height:1.6;">

        <div style="max-width:650px;margin:0 auto;border:1px solid #ddd;padding:22px;border-radius:8px;">

            <h2 style="color:#3d2a6d;">
                New Quote Request #' .
                esc_html(
                    $quote_id
                ) .
            '</h2>

            <h3>Customer Details</h3>

            <ul>
                <li><strong>Name:</strong> ' .
                    esc_html(
                        $name
                    ) .
                '</li>

                <li><strong>Email:</strong> ' .
                    esc_html(
                        $email
                    ) .
                '</li>

                <li><strong>Phone:</strong> ' .
                    esc_html(
                        $phone
                    ) .
                '</li>

                <li><strong>ZIP Code:</strong> ' .
                    esc_html(
                        $zip
                    ) .
                '</li>

                <li><strong>SMS Consent:</strong> ' .
                    esc_html(
                        $sms_consent
                    ) .
                '</li>
            </ul>


            <h3>Job Details</h3>

            <ul>

                <li><strong>Items:</strong> ' .
                    esc_html(
                        implode(
                            ', ',
                            $job_type_labels
                        )
                    ) .
                '</li>

                <li><strong>Location:</strong> ' .
                    esc_html(
                        $access_labels[
                            $access
                        ]
                    ) .
                '</li>

                ' .
                    $conditional_html .
                '

                <li><strong>Description:</strong> ' .
                    nl2br(
                        esc_html(
                            $description
                            ? $description
                            : 'N/A'
                        )
                    ) .
                '</li>

            </ul>


            <h3>Timing</h3>

            <ul>

                <li><strong>Requested Timing:</strong> ' .
                    esc_html(
                        $timing_display
                    ) .
                '</li>

                <li><strong>Preferred Date:</strong> ' .
                    esc_html(
                        $preferred_date
                        ? $preferred_date
                        : 'N/A'
                    ) .
                '</li>

            </ul>


            <h3>Additional Notes</h3>

            <p>' .
                nl2br(
                    esc_html(
                        $notes
                        ? $notes
                        : 'None'
                    )
                ) .
            '</p>


            <h3>Uploaded Photos</h3>

            ' .
                $images_html .
            '

        </div>

    </body>
    </html>';


    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'Reply-To: ' .
            $name .
            ' <' .
            $email .
            '>',
    );


    wp_mail(
        $admin_emails,
        $subject,
        $message,
        $headers
    );


    /**
     * Customer confirmation email.
     */
    $customer_subject =
        'We received your Junk Robbers quote request';


    $customer_message = '
    <html>
    <body style="font-family:Arial,sans-serif;color:#333;line-height:1.6;">

        <div style="max-width:600px;margin:0 auto;border:1px solid #ddd;padding:22px;border-radius:8px;">

            <h2 style="color:#3d2a6d;">
                Thanks for reaching out to Junk Robbers!
            </h2>

            <p>
                Hi ' .
                esc_html(
                    $name
                ) .
                ',
            </p>

            <p>
                We\'ve received your quote request and will review the details you provided.
            </p>

            <p>
                We\'ll get back to you shortly with pricing or any questions we need to finalize your quote.
            </p>

            <p>
                If you need to add anything in the meantime, you can reply to this email or call/text us at
                <strong>(312) 521-0935</strong>.
            </p>

            <p>
                Thank you,<br>
                <strong>Junk Robbers Inc.</strong><br>
                Chicago\'s Local Junk Removal Experts
            </p>

        </div>

    </body>
    </html>';


    $customer_headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'Reply-To: Junk Robbers <info@junkrobbers.com>',
    );


    wp_mail(
        $email,
        $customer_subject,
        $customer_message,
        $customer_headers
    );


    wp_send_json_success(
        array(
            'message' =>
                'Quote submitted successfully.',

            'quote_id' =>
                $quote_id,
        )
    );
}


add_action(
    'wp_ajax_ai_junk_quote_submit_form',
    'ai_junk_quote_handle_form_submission'
);


add_action(
    'wp_ajax_nopriv_ai_junk_quote_submit_form',
    'ai_junk_quote_handle_form_submission'
);


add_action(
    'wp_ajax_ai_junk_quote_upload_photo',
    'ai_junk_quote_handle_photo_upload'
);


add_action(
    'wp_ajax_nopriv_ai_junk_quote_upload_photo',
    'ai_junk_quote_handle_photo_upload'
);
