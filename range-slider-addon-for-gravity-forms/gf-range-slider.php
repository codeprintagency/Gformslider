<?php
/*
Plugin Name: Range Slider Addon for Gravity Forms
Plugin Url: https://pluginscafe.com/plugin/range-slider-for-gravity-forms-pro/
Version: 1.1.5
Description: A sleek, lightweight, and customizable range slider designed for selecting numbers or data within Gravity Forms.
Author: PluginsCafe
Author URI: https://pluginscafe.com
License: GPLv2 or later
Text Domain: range-slider-addon-for-gravity-forms
*/
if (!defined('ABSPATH')) {
    exit;
}

if (function_exists('rsfgf_fs')) {
    rsfgf_fs()->set_basename(false, __FILE__);
} else {

    if (! function_exists('rsfgf_fs')) {
        // Create a helper function for easy SDK access.
        function rsfgf_fs() {
            global $rsfgf_fs;

            if (! isset($rsfgf_fs)) {
                // Include Freemius SDK.
                require_once dirname(__FILE__) . '/vendor/freemius/start.php';
                $rsfgf_fs = fs_dynamic_init(array(
                    'id'                  => '15078',
                    'slug'                => 'range-slider-for-gravity-forms',
                    'type'                => 'plugin',
                    'public_key'          => 'pk_a6b08be24cb45ef6ac1489c6734c0',
                    'is_premium'          => false,
                    'premium_suffix'      => 'Pro',
                    // If your plugin is a serviceware, set this option to false.
                    'has_premium_version' => true,
                    'has_addons'          => false,
                    'has_paid_plans'      => true,
                    'menu'                => array(
                        'slug'           => 'range-slider-for-gravity-forms',
                        'first-path'     => 'options-general.php?page=range-slider-for-gravity-forms',
                        'contact'        => false,
                        'support'        => false,
                        'parent'         => array(
                            'slug' => 'options-general.php',
                        ),
                        'is_live'        => true,
                    ),
                ));
            }

            return $rsfgf_fs;
        }

        // Init Freemius.
        rsfgf_fs();
        // Signal that SDK was initiated.
        do_action('rsfgf_fs_loaded');
    }

    define('GF_NU_RANGE_SLIDER_ADDON_VERSION', '1.1.5');
    define('GF_NU_RANGE_SLIDER_URL', plugin_dir_url(__FILE__));
    add_action('gform_loaded', array('GF_NU_Range_Slider_AddOn_Bootstrap', 'load'), 5);

    require 'includes/admin/class-menu.php';

    class GF_NU_Range_Slider_AddOn_Bootstrap {

        public static function load() {

            if (! method_exists('GFForms', 'include_addon_framework')) {
                return;
            }
            // are we on GF 2.5+
            define('GFRS_GF_MIN_2_5', version_compare(GFCommon::$version, '2.5-dev-1', '>='));

            require_once('includes/fields/class-nu-range-slider.php');
            require_once('includes/fields/class-nu-range-slider-field.php');

            GFAddOn::register('GFRangeSliderAddOn');
        }
    }

    function gf_nu_range_slider() {
        return GFRangeSliderAddOn::get_instance();
    }
}
