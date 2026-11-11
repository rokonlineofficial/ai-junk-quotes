(function () {
    'use strict';

    var selectedFiles = [];
    var MAX_FILES = 8;
    var MAX_FILE_SIZE = 10 * 1024 * 1024;
    var ALLOWED_TYPES = [
        'image/jpeg',
        'image/png',
        'image/webp'
    ];

    function byId(id) {
        return document.getElementById(id);
    }

    function checkedValues(name) {
        return Array.prototype.map.call(
            document.querySelectorAll(
                'input[name="' + name + '"]:checked'
            ),
            function (input) {
                return input.value;
            }
        );
    }

    function checkedValue(name) {
        var checked = document.querySelector(
            'input[name="' + name + '"]:checked'
        );

        return checked ? checked.value : '';
    }

    function show(element) {
        if (element) {
            element.style.display = '';
        }
    }

    function hide(element) {
        if (element) {
            element.style.display = 'none';
        }
    }

    function showError(id, showIt) {
        var element = byId(id);

        if (!element) {
            return;
        }

        element.style.display = showIt ? 'block' : 'none';
    }

    function clearErrors() {
        Array.prototype.forEach.call(
            document.querySelectorAll('.qf-error'),
            function (error) {
                error.style.display = 'none';
            }
        );
    }

    function scrollToForm() {
        var root = byId('qf-root');

        if (!root) {
            return;
        }

        try {
            root.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        } catch (e) {
            root.scrollIntoView(true);
        }
    }

    function updateProgress(step) {
        var label = byId('qf-step-label');
        var fill = byId('qf-progress-fill');

        if (label) {
            if (step === 1) {
                label.textContent = 'Step 1 of 3 - Location';
            } else if (step === 2) {
                label.textContent = 'Step 2 of 3 - Job Details';
            } else if (step === 3) {
                label.textContent = 'Step 3 of 3 - Timing & Contact';
            }
        }

        if (fill) {
            if (step === 1) {
                fill.style.width = '33.333%';
            } else if (step === 2) {
                fill.style.width = '66.666%';
            } else if (step === 3) {
                fill.style.width = '100%';
            }
        }
    }

    function showStep(step) {
        Array.prototype.forEach.call(
            document.querySelectorAll('#qf-root .qf-step'),
            function (element) {
                element.style.display = 'none';
            }
        );

        var target = document.querySelector(
            '#qf-root .qf-step[data-step="' + step + '"]'
        );

        if (target) {
            target.style.display = '';
        }

        if (
            step === 1 ||
            step === 2 ||
            step === 3
        ) {
            updateProgress(step);
        }

        scrollToForm();
    }

    function updateConditionals() {
        var jobTypes = checkedValues('qf-job-types');
        var access = byId('qf-access')
            ? byId('qf-access').value
            : '';

        var timing = checkedValue('qf-timing');

        var heavyWrap = byId('qf-heavy-material-wrap');
        var upperWrap = byId('qf-upper-floor-wrap');
        var basementWrap = byId('qf-basement-wrap');
        var dateWrap = byId('qf-date-wrap');

        if (
            jobTypes.indexOf(
                'construction_heavy_debris'
            ) !== -1
        ) {
            show(heavyWrap);
        } else {
            hide(heavyWrap);

            if (byId('qf-heavy-material')) {
                byId('qf-heavy-material').value = '';
            }

            showError(
                'qf-heavy-material-error',
                false
            );
        }

        if (access === 'upper_floor') {
            show(upperWrap);
        } else {
            hide(upperWrap);

            if (byId('qf-floor')) {
                byId('qf-floor').value = '';
            }

            if (byId('qf-elevator')) {
                byId('qf-elevator').value = '';
            }

            showError('qf-floor-error', false);
            showError('qf-elevator-error', false);
        }

        if (access === 'basement') {
            show(basementWrap);
        } else {
            hide(basementWrap);

            if (byId('qf-basement-access')) {
                byId('qf-basement-access').value = '';
            }

            showError(
                'qf-basement-access-error',
                false
            );
        }

        if (timing === 'preferred_date') {
            show(dateWrap);
        } else {
            hide(dateWrap);

            if (byId('qf-date')) {
                byId('qf-date').value = '';
            }

            showError('qf-date-error', false);
        }
    }

    function validateStep1() {
        clearErrors();

        var zip = byId('qf-zip')
            ? byId('qf-zip').value.trim()
            : '';

        var valid = /^\d{5}$/.test(zip);

        showError('qf-zip-error', !valid);

        return valid;
    }

    function validateStep2() {
        clearErrors();

        var valid = true;
        var jobTypes = checkedValues('qf-job-types');

        var access = byId('qf-access')
            ? byId('qf-access').value
            : '';

        if (!jobTypes.length) {
            showError(
                'qf-job-types-error',
                true
            );
            valid = false;
        }

        if (
            jobTypes.indexOf(
                'construction_heavy_debris'
            ) !== -1
        ) {
            var heavy = byId('qf-heavy-material')
                ? byId('qf-heavy-material').value
                : '';

            if (!heavy) {
                showError(
                    'qf-heavy-material-error',
                    true
                );
                valid = false;
            }
        }

        if (!access) {
            showError('qf-access-error', true);
            valid = false;
        }

        if (access === 'upper_floor') {
            var floor = byId('qf-floor')
                ? byId('qf-floor').value
                : '';

            var elevator = byId('qf-elevator')
                ? byId('qf-elevator').value
                : '';

            if (!floor) {
                showError(
                    'qf-floor-error',
                    true
                );
                valid = false;
            }

            if (!elevator) {
                showError(
                    'qf-elevator-error',
                    true
                );
                valid = false;
            }
        }

        if (access === 'basement') {
            var basementAccess =
                byId('qf-basement-access')
                    ? byId(
                        'qf-basement-access'
                    ).value
                    : '';

            if (!basementAccess) {
                showError(
                    'qf-basement-access-error',
                    true
                );
                valid = false;
            }
        }

        return valid;
    }

    function validateEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(
            email
        );
    }

    function validateStep3() {
        clearErrors();

        var valid = true;

        var timing = checkedValue('qf-timing');

        var name = byId('qf-name')
            ? byId('qf-name').value.trim()
            : '';

        var phone = byId('qf-phone')
            ? byId('qf-phone').value.trim()
            : '';

        var email = byId('qf-email')
            ? byId('qf-email').value.trim()
            : '';

        if (!timing) {
            showError(
                'qf-timing-error',
                true
            );
            valid = false;
        }

        if (timing === 'preferred_date') {
            var date = byId('qf-date')
                ? byId('qf-date').value
                : '';

            if (!date) {
                showError(
                    'qf-date-error',
                    true
                );
                valid = false;
            }
        }

        if (name.length < 2) {
            showError(
                'qf-name-error',
                true
            );
            valid = false;
        }

        if (
            phone.replace(/\D/g, '').length < 7
        ) {
            showError(
                'qf-phone-error',
                true
            );
            valid = false;
        }

        if (!validateEmail(email)) {
            showError(
                'qf-email-error',
                true
            );
            valid = false;
        }

        return valid;
    }

    function renderFiles() {
        var list = byId('qf-file-list');

        if (!list) {
            return;
        }

        list.innerHTML = '';

        selectedFiles.forEach(
            function (file, index) {
                var row =
                    document.createElement('div');

                row.className = 'qf-file-item';

                var name =
                    document.createElement('span');

                name.textContent = file.name;

                var remove =
                    document.createElement('button');

                remove.type = 'button';
                remove.textContent = 'Remove';
                remove.className =
                    'qf-file-remove';

                remove.addEventListener(
                    'click',
                    function () {
                        selectedFiles.splice(
                            index,
                            1
                        );

                        renderFiles();
                    }
                );

                row.appendChild(name);
                row.appendChild(remove);

                list.appendChild(row);
            }
        );
    }

    function addFiles(files) {
        var error = byId('qf-files-error');

        if (error) {
            error.style.display = 'none';
            error.textContent = '';
        }

        Array.prototype.forEach.call(
            files,
            function (file) {
                if (
                    selectedFiles.length >=
                    MAX_FILES
                ) {
                    return;
                }

                if (
                    ALLOWED_TYPES.indexOf(
                        file.type
                    ) === -1
                ) {
                    if (error) {
                        error.textContent =
                            'Only JPG, PNG and WebP photos are allowed.';

                        error.style.display =
                            'block';
                    }

                    return;
                }

                if (
                    file.size >
                    MAX_FILE_SIZE
                ) {
                    if (error) {
                        error.textContent =
                            'Each photo must be 10 MB or smaller.';

                        error.style.display =
                            'block';
                    }

                    return;
                }

                selectedFiles.push(file);
            }
        );

        if (
            files.length +
            selectedFiles.length >
            MAX_FILES
        ) {
            if (error) {
                error.textContent =
                    'You can upload up to 8 photos.';

                error.style.display =
                    'block';
            }
        }

        renderFiles();
    }

    function buildFormData() {
        var formData = new FormData();

        /*
         * IMPORTANT:
         * These names exactly match
         * form-handler.php.
         */

        formData.append(
            'action',
            'ai_junk_quote_submit_form'
        );

        if (
            typeof aiJunkQuoteData !==
                'undefined' &&
            aiJunkQuoteData.nonce
        ) {
            formData.append(
                'nonce',
                aiJunkQuoteData.nonce
            );
        }

        formData.append(
            'zip',
            byId('qf-zip')
                ? byId('qf-zip').value.trim()
                : ''
        );

        checkedValues(
            'qf-job-types'
        ).forEach(
            function (value) {
                formData.append(
                    'job_types[]',
                    value
                );
            }
        );

        formData.append(
            'description',
            byId('qf-description')
                ? byId(
                    'qf-description'
                ).value.trim()
                : ''
        );

        formData.append(
            'access',
            byId('qf-access')
                ? byId('qf-access').value
                : ''
        );

        formData.append(
            'floor',
            byId('qf-floor')
                ? byId('qf-floor').value
                : ''
        );

        formData.append(
            'elevator',
            byId('qf-elevator')
                ? byId('qf-elevator').value
                : ''
        );

        /*
         * Exact PHP field name:
         * basementAccess
         */
        formData.append(
            'basementAccess',
            byId('qf-basement-access')
                ? byId(
                    'qf-basement-access'
                ).value
                : ''
        );

        /*
         * Exact PHP field name:
         * heavyMaterial
         */
        formData.append(
            'heavyMaterial',
            byId('qf-heavy-material')
                ? byId(
                    'qf-heavy-material'
                ).value
                : ''
        );

        formData.append(
            'timing',
            checkedValue('qf-timing')
        );

        /*
         * Exact PHP field name:
         * preferredDate
         */
        formData.append(
            'preferredDate',
            byId('qf-date')
                ? byId('qf-date').value
                : ''
        );

        formData.append(
            'name',
            byId('qf-name')
                ? byId('qf-name').value.trim()
                : ''
        );

        formData.append(
            'phone',
            byId('qf-phone')
                ? byId('qf-phone').value.trim()
                : ''
        );

        formData.append(
            'email',
            byId('qf-email')
                ? byId('qf-email').value.trim()
                : ''
        );

        formData.append(
            'notes',
            byId('qf-notes')
                ? byId('qf-notes').value.trim()
                : ''
        );

        /*
         * PHP checks specifically for
         * the string "true".
         */
        formData.append(
            'smsConsent',
            byId('qf-sms-consent') &&
            byId('qf-sms-consent').checked
                ? 'true'
                : 'false'
        );

        selectedFiles.forEach(
            function (file) {
                /*
                 * PHP expects $_FILES['files']
                 */
                formData.append(
                    'files[]',
                    file,
                    file.name
                );
            }
        );

        return formData;
    }

    window.qfGoToStep = function (step) {
        if (step === 2) {
            if (!validateStep1()) {
                return;
            }
        }

        if (step === 3) {
            if (!validateStep2()) {
                return;
            }
        }

        showStep(step);
        updateConditionals();
    };

    window.qfSubmit = function () {
        if (!validateStep3()) {
            return;
        }

        var submitButton =
            byId('qf-submit-btn');

        var originalText =
            submitButton
                ? submitButton.textContent
                : '';

        if (submitButton) {
            submitButton.disabled = true;
            submitButton.textContent =
                'SUBMITTING...';
        }

        var ajaxUrl =
            typeof aiJunkQuoteData !==
                'undefined' &&
            aiJunkQuoteData.ajax_url
                ? aiJunkQuoteData.ajax_url
                : '/wp-admin/admin-ajax.php';

        fetch(
            ajaxUrl,
            {
                method: 'POST',
                body: buildFormData(),
                credentials: 'same-origin'
            }
        )
            .then(function (response) {
                return response.text();
            })
            .then(function (text) {
                var result;

                try {
                    result = JSON.parse(text);
                } catch (e) {
                    console.error(
                        'Quote form response:',
                        text
                    );

                    throw new Error(
                        'Invalid server response.'
                    );
                }

                if (!result.success) {
                    var message =
                        result.data &&
                        result.data.message
                            ? result.data.message
                            : 'We could not submit your quote. Please try again.';

                    throw new Error(message);
                }

                if (typeof window.gtag === 'function') {
                    window.gtag('event', 'generate_lead', {
                        form_name: 'junk_removal_quote'
                    });
                }

                showStep('thankyou');

                var label =
                    byId('qf-step-label');

                var fill =
                    byId('qf-progress-fill');

                if (label) {
                    label.textContent =
                        'Quote Request Received';
                }

                if (fill) {
                    fill.style.width =
                        '100%';
                }
            })
            .catch(function (error) {
                console.error(error);

                alert(
                    error.message ||
                    'We could not submit your quote. Please try again.'
                );
            })
            .finally(function () {
                if (submitButton) {
                    submitButton.disabled =
                        false;

                    submitButton.textContent =
                        originalText;
                }
            });
    };

    function initializeQuoteForm() {
        if (!byId('qf-root')) {
            return;
        }

        var step1Next =
            byId('qf-step1-next');

        var step2Back =
            byId('qf-step2-back');

        var step2Next =
            byId('qf-step2-next');

        var step3Back =
            byId('qf-step3-back');

        var submitButton =
            byId('qf-submit-btn');

        var access =
            byId('qf-access');

        var fileInput =
            byId('qf-file-input');

        var choosePhotos =
            byId('qf-select-files');

        var dropzone =
            byId('qf-dropzone');

        if (step1Next) {
            step1Next.addEventListener(
                'click',
                function () {
                    window.qfGoToStep(2);
                }
            );
        }

        if (step2Back) {
            step2Back.addEventListener(
                'click',
                function () {
                    showStep(1);
                }
            );
        }

        if (step2Next) {
            step2Next.addEventListener(
                'click',
                function () {
                    window.qfGoToStep(3);
                }
            );
        }

        if (step3Back) {
            step3Back.addEventListener(
                'click',
                function () {
                    showStep(2);
                }
            );
        }

        if (submitButton) {
            submitButton.addEventListener(
                'click',
                function () {
                    window.qfSubmit();
                }
            );
        }

        Array.prototype.forEach.call(
            document.querySelectorAll(
                'input[name="qf-job-types"]'
            ),
            function (input) {
                input.addEventListener(
                    'change',
                    updateConditionals
                );
            }
        );

        if (access) {
            access.addEventListener(
                'change',
                updateConditionals
            );
        }

        Array.prototype.forEach.call(
            document.querySelectorAll(
                'input[name="qf-timing"]'
            ),
            function (input) {
                input.addEventListener(
                    'change',
                    updateConditionals
                );
            }
        );

        if (
            choosePhotos &&
            fileInput
        ) {
            choosePhotos.addEventListener(
                'click',
                function (event) {
                    event.preventDefault();
                    event.stopPropagation();
                    fileInput.click();
                }
            );
        }

        if (fileInput) {
            fileInput.addEventListener(
                'change',
                function () {
                    addFiles(
                        fileInput.files
                    );

                    fileInput.value = '';
                }
            );
        }

        if (dropzone) {
            dropzone.addEventListener(
                'dragover',
                function (event) {
                    event.preventDefault();
                }
            );

            dropzone.addEventListener(
                'drop',
                function (event) {
                    event.preventDefault();

                    if (
                        event.dataTransfer &&
                        event.dataTransfer.files
                    ) {
                        addFiles(
                            event.dataTransfer.files
                        );
                    }
                }
            );
        }

        /*
         * Prevent past dates.
         */
        var dateInput = byId('qf-date');

        if (dateInput) {
            var today = new Date();
            var year =
                today.getFullYear();

            var month =
                String(
                    today.getMonth() + 1
                ).padStart(2, '0');

            var day =
                String(
                    today.getDate()
                ).padStart(2, '0');

            dateInput.min =
                year + '-' +
                month + '-' +
                day;
        }

        clearErrors();
        updateConditionals();
        updateProgress(1);
    }

    document.addEventListener(
        'click',
        function (event) {
            var link =
                event.target &&
                event.target.closest
                    ? event.target.closest(
                        'a[href^=\"tel:\"]'
                    )
                    : null;

            if (
                !link ||
                typeof window.gtag !==
                'function'
            ) {
                return;
            }

            window.gtag(
                'event',
                'click_to_call',
                {
                    link_type: 'phone'
                }
            );
        }
    );

    if (
        document.readyState ===
        'loading'
    ) {
        document.addEventListener(
            'DOMContentLoaded',
            initializeQuoteForm
        );
    } else {
        initializeQuoteForm();
    }

})();