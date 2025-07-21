<?php

$GFRS_Plugins = [
    [
        'name' => 'Smart phone field for Gravity Forms',
        'slug' => 'smart-phone-field-for-gravity-forms',
        'path' => 'smart-phone-field-for-gravity-forms/gravityforms-smart-phone-field.php',
        'desc' => 'A simple and nice plugin to get auto country flag from user ip address on gravity form phone field. It will help you to get the country flag on the phone field.',
        'demo' => 'https://pluginscafe.com/demo/smart-phone-field-for-gravity-forms/',
        'img'  => 'spf.svg'
    ],
    [
        'name' => 'Real Time Validation For Gravity Forms',
        'slug' => 'gf-real-time-validation',
        'path' => 'gf-real-time-validation/real-time-validation.php',
        'desc' => 'This plugin adds an awesome feature that provides instant feedback and guidance in each field, helps prevent errors.',
        'demo' => '',
        'img'  => 'imp.svg'
    ],
    [
        'name' => 'Image Picker For Gravity Forms',
        'slug' => 'gf-real-time-validation',
        'path' => 'image-choices-for-gravity-forms/gf-img-choices.php',
        'desc' => 'A lightweight and user-friendly plugin for effortlessly adding images to Gravity Forms radio and checkbox fields. With just a few clicks, you can upload and assign images to these fields seamlessly.',
        'demo' => '',
        'img'  => 'imp.svg',
    ],
    [
        'name' => 'Easy Integration with Google Calendar',
        'slug' => 'easy-integration-with-google-calendar',
        'path' => 'easy-integration-with-google-calendar/easy-integration-with-google-calendar.php',
        'desc' => 'Easily integrate Google Calendar with your WordPress site in just few minutes using your forms.',
        'demo' => '',
        'img'  => 'imp.svg',
    ],
    [
        'name' => 'Advanced Data Table for Elementor',
        'slug' => 'advanced-data-table-for-elementor',
        'path' => 'advanced-data-table-for-elementor/advanced-data-table.php',
        'desc' => 'Advanced Data Table for Elementor is an essential plugin for Elementor users who want to easily create visually appealing and functional tables on their WordPress websites.',
        'demo' => '',
        'img'  => 'imp.svg',
    ],
    [
        'name' => 'Restrict Dates Addon For Gravity Forms',
        'slug' => 'restrict-dates-add-on-for-gravity-forms',
        'path' => 'restrict-dates-add-on-for-gravity-forms/restrict-dates.php',
        'desc' => 'Restrict which dates are not selectable in your Gravity Forms date picker field. It helps to provide accurate services to your users.',
        'demo' => 'https://pluginscafe.com/demo/restrict-dates-for-gravity-forms-pro/',
        'img'  => 'red.svg',
    ],
    [
        'name' => 'Formico – Elementor Form Extensions, Fields & Integrations',
        'slug' => 'formico',
        'path' => 'formico/formico.php',
        'desc' => '	The easiest and lightweight elementor pro form extensions bundle. Take your Elementor form building capabilities to the next level with our Form Extensions plugin!',
        'demo' => '',
        'img'  => 'formico.svg',
    ],
    [
        'name' => 'Address Autocomplete via Google for Gravity Forms',
        'slug' => 'gf-google-address-autocomplete',
        'path' => 'gf-google-address-autocomplete/gf-auto-address-complete.php',
        'desc' => 'A lightweight and user-friendly plugin that enables Google Places API auto-suggestions in Gravity Forms address fields.',
        'demo' => '',
        'img'  => 'aac.svg',
    ],
    [
        'name' => 'Smart Phone Field For WPForms, Contact Form 7, Fluent Forms, Elementor Form',
        'slug' => 'smart-phone-field-for-wp-forms',
        'path' => 'smart-phone-field-for-wp-forms/smart-phone-field.php',
        'desc' => '	Instruct your visitors to choose their country code when entering their mobile number to ensure accurate and correctly formatted data submissions.',
        'demo' => 'https://pluginscafe.com/demo/smart-phone-field/',
        'img'  => 'spf.svg',
    ],
    [
        'name' => 'PDF Invoices for Gravity Forms',
        'slug' => 'pdf-invoices-for-gravity-forms',
        'path' => 'pdf-invoices-for-gravity-forms/pdf-invoices.php',
        'desc' => 'Automatically generate PDF invoices and attach them to every form submission in Gravity Forms.',
        'demo' => '',
        'img'  => 'pdfi.svg',
    ],
    [
        'name' => 'Advanced Date Time Field',
        'slug' => 'advanced-date-time-field',
        'path' => 'advanced-date-time-field/advanced-date-time-field.php',
        'desc' => 'This plugin is a lightweight yet powerful date and time picker designed for popular form builder plugins.',
        'demo' => '',
        'img'  => 'imp.svg',
    ],
    [
        'name' => 'Connect Brevo With Gravity Forms',
        'slug' => 'connect-brevo-gravity-forms',
        'path' => 'connect-brevo-gravity-forms/gf-brevo.php',
        'desc' => 'When someone submits a form on your site, it sends form submissions from Gravity Forms to the relationship marketing platform Brevo (ex Sendinblue).',
        'demo' => '',
        'img'  => 'brevo.svg',
    ],
    [
        'name' => 'Klaviyo for Gravity Forms',
        'slug' => 'klaviyo-for-gravity-forms',
        'path' => 'klaviyo-for-gravity-forms/gf-klaviyo.php',
        'desc' => 'When someone submits a form on your site, it sends form submissions from Gravity Forms to the relationship marketing platform Klaviyo.',
        'demo' => '',
        'img'  => 'klaviyo.svg',
    ]
];


?>

<div id="otherplugins" class="other_plugins_content tab_item">
    <div class="content_heading">
        <h2><?php esc_html_e('Try out our recommended plugins', 'range-slider-addon-for-gravity-forms'); ?></h2>
    </div>

    <div class="pcafe_plugin_wrap">
        <?php foreach ($GFRS_Plugins as $key => $plugin) :
            $plugin_path = WP_PLUGIN_DIR . '/' . $plugin['path'];
            $plugin_file = $plugin['slug'];
            $path = $plugin['path'];

            if (file_exists(WP_PLUGIN_DIR . '/' . $plugin_file)) {
                $url = admin_url("plugins.php?action=activate&plugin=$path");
                $url = wp_nonce_url($url, "activate-plugin_{$path}");
                $btn_text = esc_html__('Activate', 'range-slider-addon-for-gravity-forms');
                $css_class = 'p__activate';
            } else {
                $url = admin_url("update.php?action=install-plugin&plugin=$plugin_file");
                $url = wp_nonce_url($url, "install-plugin_$plugin_file");
                $btn_text = esc_html__('Install', 'range-slider-addon-for-gravity-forms');
                $css_class = 'p__install';
            }
        ?>
            <div class="single_plugin">
                <div class="p__name">
                    <img src="<?php echo esc_url(GF_NU_RANGE_SLIDER_URL . '/includes/admin/img/' . $plugin['img']); ?>" alt="">
                    <h4><?php echo esc_attr($plugin['name']); ?></h4>
                </div>
                <div class="p__content">
                    <div class="p__desc">
                        <?php echo esc_html($plugin['desc']); ?>
                    </div>
                    <div class="p__btns">
                        <?php if (is_plugin_active($plugin['path'])) : ?>
                            <p class="p__activated">
                                <?php esc_html_e('Activated', 'range-slider-addon-for-gravity-forms'); ?>
                                <svg xmlns="http://www.w3.org/2000/svg" height="20" width="20" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                    <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                                </svg>
                            </p>
                        <?php else : ?>
                            <a href="<?php echo esc_url($url); ?>" class="install_btn <?php echo esc_attr($css_class); ?>">
                                <span class="p_btn_text"><?php echo esc_html($btn_text); ?></span>
                                <span class="loader"></span>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($plugin['demo'])) : ?>
                            <a href="<?php echo esc_url($plugin['demo']); ?>" class="p__demo" target="_blank"><?php esc_html_e('Demo', 'range-slider-addon-for-gravity-forms'); ?></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>