<?php
if (!defined('ABSPATH')) {
    exit;
}

class GF_Range_Slider_Menu {
    public function __construct() {
        add_filter('admin_footer_text', [$this, 'admin_footer'], 1, 2);
        add_action('admin_menu', [$this, 'add_menu']);
        add_action('admin_enqueue_scripts', [$this, 'admin_scripts']);
        add_action('admin_notices', [$this, 'review_request']);
        add_action('admin_notices', [$this, 'upgrade_notice']);
        add_action('wp_ajax_rs_review_dismiss', [$this, 'rs_review_dismiss']);
        add_action('wp_ajax_upgrade_notice_dismiss', [$this, 'upgrade_notice_dismiss']);
    }

    public function admin_scripts() {
        $current_screen = get_current_screen();
        if (strpos($current_screen->base, 'range-slider-for-gravity-forms') === false) {
            return;
        }

        wp_enqueue_style('gfrs_admin_style', GF_NU_RANGE_SLIDER_URL . 'assets/css/gfrs_admin.css', array(), GF_NU_RANGE_SLIDER_ADDON_VERSION);
        wp_enqueue_script('gfrs_admin_js', GF_NU_RANGE_SLIDER_URL . 'assets/js/gfrs_admin.js', array('jquery'), GF_NU_RANGE_SLIDER_ADDON_VERSION, true);
    }

    public function add_menu() {
        add_submenu_page(
            'options-general.php',
            'Range Slider for Gravity Forms',
            'GF Range Slider',
            'administrator',
            'range-slider-for-gravity-forms',
            [$this, 'range_slider_page']
        );
    }

    public function range_slider_page() {
        echo '<div class="pcafe_wrapper">';
        include_once __DIR__ . '/dashboard.php';

        echo '<div id="pcafe_tab_box" class="pcafe_container">';
        include_once __DIR__ . '/introduction.php';
        include_once __DIR__ . '/usage.php';
        include_once __DIR__ . '/help.php';
        include_once __DIR__ . '/pro.php';
        include_once __DIR__ . '/other-plugins.php';
        echo '</div>';
        echo '</div>';
    }

    public function admin_footer($text) {
        global $current_screen;

        if (! empty($current_screen->id) && strpos($current_screen->id, 'range-slider-for-gravity-forms') !== false) {
            $url  = 'https://wordpress.org/support/plugin/range-slider-addon-for-gravity-forms/reviews/?filter=5#new-post';
            $text = sprintf(
                wp_kses(
                    /* translators: $1$s - WPForms plugin name; $2$s - WP.org review link; $3$s - WP.org review link. */
                    __('Thank you for using %1$s. Please rate us <a href="%2$s" target="_blank" rel="noopener noreferrer">&#9733;&#9733;&#9733;&#9733;&#9733;</a> on <a href="%3$s" target="_blank" rel="noopener">WordPress.org</a> to boost our motivation.', 'range-slider-addon-for-gravity-forms'),
                    array(
                        'a' => array(
                            'href'   => array(),
                            'target' => array(),
                            'rel'    => array(),
                        ),
                    )
                ),
                '<strong>Range Slider Addon For Gravity Forms</strong>',
                $url,
                $url
            );
        }

        return $text;
    }

    public function review_request() {
        if (! is_super_admin()) {
            return;
        }

        $time = time();
        $load = false;

        $review = get_option('gfrs_review_status');

        if (! $review) {
            $review_time = strtotime("+15 days", time());
            update_option('gfrs_review_status', $review_time);
        } else {
            if (! empty($review) && $time > $review) {
                $load = true;
            }
        }
        if (! $load) {
            return;
        }

        $this->review();
    }

    public function review() {
        $current_user = wp_get_current_user();
?>
        <div class="notice notice-info is-dismissible gfrs_review_notice">
            <p><?php
                sprintf(
                    /* translators: 1: user display name 2: plugin name */
                    esc_html__('Hey %1$s 👋, I noticed you are using <strong>%2$s</strong> for a few days - that\'s Awesome!  If you feel <strong>%2$s</strong> is helping your business to grow in any way, Could you please do us a BIG favor and give it a 5-star rating on WordPress to boost our motivation?', 'range-slider-addon-for-gravity-forms'),
                    esc_attr($current_user->display_name),
                    'Range Slider Addon For Gravity Forms'
                );
                ?>
            </p>
            <ul style="margin-bottom: 5px">
                <li style="display: inline-block">
                    <a style="padding: 5px 5px 5px 0; text-decoration: none;" target="_blank" href="<?php echo esc_url('https://wordpress.org/support/plugin/range-slider-addon-for-gravity-forms/reviews/?filter=5#new-post') ?>">
                        <span class="dashicons dashicons-external"></span><?php esc_html_e(' Ok, you deserve it!', 'range-slider-addon-for-gravity-forms') ?>
                    </a>
                </li>
                <li style="display: inline-block">
                    <a style="padding: 5px; text-decoration: none;" href="#" class="rs_already_done" data-status="already">
                        <span class="dashicons dashicons-smiley"></span>
                        <?php esc_html_e('I already did', 'range-slider-addon-for-gravity-forms') ?>
                    </a>
                </li>
                <li style="display: inline-block">
                    <a style="padding: 5px; text-decoration: none;" href="#" class="rs_later" data-status="rs_later">
                        <span class="dashicons dashicons-calendar-alt"></span>
                        <?php esc_html_e('Maybe Later', 'range-slider-addon-for-gravity-forms') ?>
                    </a>
                </li>
                <li style="display: inline-block">
                    <a style="padding: 5px; text-decoration: none;" target="_blank" href="<?php echo esc_url('https://pluginscafe.com/support/') ?>">
                        <span class="dashicons dashicons-sos"></span>
                        <?php esc_html_e('I need help', 'range-slider-addon-for-gravity-forms') ?>
                    </a>
                </li>
                <li style="display: inline-block">
                    <a style="padding: 5px; text-decoration: none;" href="#" class="rs_never" data-status="rs_never">
                        <span class="dashicons dashicons-dismiss"></span>
                        <?php esc_html_e('Never show again', 'range-slider-addon-for-gravity-forms') ?>
                    </a>
                </li>
            </ul>
        </div>
        <script>
            jQuery(document).ready(function($) {
                $(document).on('click', '.rs_already_done, .rs_later, .rs_never, .rs_notice_dismiss', function(event) {
                    event.preventDefault();
                    var $this = $(this);
                    var status = $this.attr('data-status');
                    data = {
                        action: 'rs_review_dismiss',
                        status: status,
                    };
                    $.ajax({
                        url: ajaxurl,
                        type: 'post',
                        data: data,
                        success: function(data) {
                            $('.gfrs_review_notice').remove();
                        },
                        error: function(data) {}
                    });
                });
            });
        </script>
        <?php
    }

    public function rs_review_dismiss() {
        $status = $_POST['status'];

        if ($status == 'already' || $status == 'rs_never') {
            $next_try     = strtotime("+30 days", time());
            update_option('gfrs_review_status', $next_try);
        } else if ($status == 'rs_later') {
            $next_try     = strtotime("+10 days", time());
            update_option('gfrs_review_status', $next_try);
        }
        wp_die();
    }

    public function upgrade_notice() {

        $show = false;
        if (rsfgf_fs()->is_not_paying()) {
            $show = true;
        }

        if (isset($_GET['show_notices'])) {
            delete_transient('gfrs_upgrade_notice');
            $show = true;
        }

        if (! $this->is_active_gravityforms()) { ?>
            <div id="gfrs_notice-error" class="gfrs_notice-error notice notice-error">
                <div class="notice-container" style="padding:10px">
                    <span> <?php esc_html_e("Range Slider AddOn needs to active gravity forms.", "range-slider-addon-for-gravity-forms"); ?></span>
                </div>
            </div>
            <?php
        } else {
            if ($show && false == get_transient('gfrs_upgrade_notice') && current_user_can('install_plugins')) {
            ?>

                <div id="gfrs_upgrade_notice" class="gfrs_upgrade_notice notice is-dismissible">
                    <div class="notice_container">
                        <div class="notice_wrap">
                            <div class="rda_img">
                                <img width="100px" src="<?php echo esc_url(GF_NU_RANGE_SLIDER_URL . '/assets/images/range-slider.svg'); ?>" class="gfrs_logo">
                            </div>
                            <div class="notice-content">
                                <div class="notice-heading">
                                    <?php esc_html_e("Hi there, Thanks for using Range Slider Addon for Gravity Forms", "range-slider-addon-for-gravity-forms"); ?>
                                </div>
                                <?php esc_html_e("Did you know our PRO version includes the ability to use text slider, double handle and more features? Check it out!", "range-slider-addon-for-gravity-forms"); ?>
                                <div class="gfrs_review-notice-container">
                                    <a href="https://pluginscafe.com/demo/range-slider-for-gravity-forms/" class="gfrs_notice-close gfrs_review-notice button-primary" target="_blank">
                                        <?php esc_html_e("See The Demo", "range-slider-addon-for-gravity-forms"); ?>
                                    </a>
                                    <span class="dashicons dashicons-smiley"></span>
                                    <a href="#" class="gfrs_notice-close notice-dis gfrs_review-notice">
                                        <?php esc_html_e("Dismiss", "range-slider-addon-for-gravity-forms"); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="gfrs_upgrade_btn">
                            <a href="<?php echo esc_url(admin_url('options-general.php?page=range-slider-for-gravity-forms')); ?>">
                                <?php esc_html_e('Upgrade Now!', 'range-slider-addon-for-gravity-forms'); ?>
                            </a>
                        </div>
                    </div>
                    <style>
                        .notice_container {
                            display: flex;
                            align-items: center;
                            padding: 10px 0;
                            gap: 15px;
                            justify-content: space-between;
                        }

                        img.gfrs_logo {
                            max-width: 90px;
                        }

                        .notice-heading {
                            font-size: 16px;
                            font-weight: 500;
                            margin-bottom: 5px;
                        }

                        .gfrs_review-notice-container {
                            margin-top: 11px;
                            display: flex;
                            align-items: center;
                        }

                        .gfrs_notice-close {
                            padding-left: 5px;
                        }

                        span.dashicons.dashicons-smiley {
                            padding-left: 15px;
                        }

                        .notice_wrap {
                            display: flex;
                            align-items: center;
                            gap: 15px;
                        }

                        .gfrs_upgrade_btn a {
                            text-decoration: none;
                            font-size: 15px;
                            background: #7BBD02;
                            color: #fff;
                            display: inline-block;
                            padding: 10px 20px;
                            border-radius: 3px;
                            transition: 0.3s;
                        }

                        .gfrs_upgrade_btn a:hover {
                            background: #69a103;
                        }
                    </style>
                    <script>
                        var $ = jQuery;
                        var admin_url_rda = '<?php echo esc_url(admin_url("admin-ajax.php")); ?>';
                        jQuery(document).on("click", '#gfrs_upgrade_notice .notice-dis', function() {
                            $(this).parents('#gfrs_upgrade_notice').find('.notice-dismiss').click();
                        });
                        jQuery(document).on("click", '#gfrs_upgrade_notice .notice-dismiss', function() {

                            var notice_id = $(this).parents('#gfrs_upgrade_notice').attr('id') || '';

                            jQuery.ajax({
                                url: admin_url_rda,
                                type: 'POST',
                                data: {
                                    action: 'upgrade_notice_dismiss',
                                    notice_id: notice_id,
                                },
                            });
                        });
                    </script>
                </div>

<?php
            }
        }
    }

    public function upgrade_notice_dismiss() {
        $notice_id = isset($_POST['notice_id']) ? sanitize_key($_POST['notice_id']) : '';
        $repeat_notice_after = 60 * 60 * 24 * 7;
        if (!empty($notice_id)) {
            if (!empty($repeat_notice_after)) {
                set_transient($notice_id, true, $repeat_notice_after);
                wp_send_json_success();
            }
        }
    }

    public function is_active_gravityforms() {
        if (!method_exists('GFForms', 'include_payment_addon_framework')) {
            return false;
        }
        return true;
    }
}

new GF_Range_Slider_Menu();
