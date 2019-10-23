<?php

//Main Plugin Class

class Interactive_Map
{

    static $instance;

    //Constructor of the Class
    public function __construct()
    {

        self::$instance = $this;

        add_action('admin_menu', array($this, 'wpInteractiveMapMenu'));
        add_action('admin_init', array($this, 'wpInteractiveMapSettings'));
        add_shortcode('interactive-map', array($this, 'interactiveMapShortcode'));
        add_action('admin_enqueue_scripts', array($this, 'interactiveMapAdminScripts'));
        add_action('wp_enqueue_scripts', array($this, 'interactiveMapFrontendScripts'));
    }

    /**
     * Function to add menu in backend
     */
    public function wpInteractiveMapMenu()
    {
        add_plugins_page('Interactive Map Settings', 'Interactive Map Settings', 'manage_options', 'interactive-map-settings', array($this, 'loadMapSettingsPage'), '', 85);
    }

    /**
     * Function to Load Map Settings Page
     */
    public function loadMapSettingsPage()
    {
        if (file_exists(plugin_dir_path(__DIR__) . '/views/interactive-map-settings.php')) {
            require plugin_dir_path(__DIR__) . '/views/interactive-map-settings.php';
        } else {
            die('<br /><h3>Plugin Installation is Incomplete. Please install the plugin again or make sure you have copied all the plugin files.</h3>');
        }
    }

    /**
     * Function to include scripts necessary for the plugin.
     */
    public function interactiveMapAdminScripts()
    {

        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('wp-color-picker');
        wp_enqueue_script('map-color-picker', plugins_url('/assets/js/interactive-admin-map.js', __DIR__), array('jquery'), '2.0.0', true);
    }

    /**
     * Frontend Scripts
     */
    public function interactiveMapFrontendScripts()
    {

        wp_enqueue_style('interactive-main-style', plugins_url('/assets/css/jqvmap.css', __DIR__));
        wp_enqueue_style('interactive-map-style', plugins_url('/assets/css/style.css', __DIR__));
        wp_enqueue_script('vmap-js-handler', plugins_url('/assets/js/jquery.vmap.js', __DIR__), array(), '1.0.0', true);
        wp_enqueue_script('vmap-worldmap-handler', plugins_url('/assets/js/maps/jquery.vmap.' . get_option('map_type') . '.js', __DIR__), array(), '2.0.0', true);

        wp_localize_script('vmap-worldmap-handler', 'interactivemap', array(
            'map' => !empty(get_option('map_type')) ? get_option('map_type') : "world",
            'map_color' => !empty(get_option('map_color')) ? get_option('map_color') : "#b9d7b8",
            'map_background_color' => !empty(get_option('map_background_color')) ? get_option('map_background_color') : "#a3cdff",
            'map_border_color' => !empty(get_option('map_border_color')) ? get_option('map_border_color') : "#000000",
            'map_zoom' => !empty(get_option('map_zoom')) ? get_option('map_zoom') : true,
            'map_region_hover_color' => !empty(get_option('map_region_hover_color')) ? get_option('map_region_hover_color') : "#779baa",
            'map_labels' => !empty(get_option('map_labels')) ? get_option('map_labels') : true,
            'map_tooltip' => !empty(get_option('map_tooltip')) ? get_option('map_tooltip') : true,
            'map_border_width' => !empty(get_option('map_border_width')) ? get_option('map_border_width') : 1,
            'map_border_opacity' => !empty(get_option('map_border_opacity')) ? get_option('map_border_opacity') : 0.50,
            'map_selected_color' => !empty(get_option('map_selected_color')) ? get_option('map_selected_color') : "#8e8770",
            'map_multiselect' => !empty(get_option('map_multiselect')) ? get_option('map_multiselect') : true,
        ));
        wp_enqueue_script('map-frontend-handler', plugins_url('/assets/js/interactive-map.js', __DIR__), array(), '2.0.0', true);
    }

    /**
     * function to register map settings
     */
    public function wpInteractiveMapSettings()
    {

        register_setting('interactive-map-settings-group', 'map_multiselect');
        register_setting('interactive-map-settings-group', 'map_selected_color');
        register_setting('interactive-map-settings-group', 'map_border_opacity');
        register_setting('interactive-map-settings-group', 'map_border_width');
        register_setting('interactive-map-settings-group', 'map_width');
        register_setting('interactive-map-settings-group', 'map_height');
        register_setting('interactive-map-settings-group', 'map_type');
        register_setting('interactive-map-settings-group', 'map_color');
        register_setting('interactive-map-settings-group', 'map_background_color');
        register_setting('interactive-map-settings-group', 'map_border_color');
        register_setting('interactive-map-settings-group', 'map_zoom');
        register_setting('interactive-map-settings-group', 'map_region_hover_color');
        register_setting('interactive-map-settings-group', 'map_labels');
        register_setting('interactive-map-settings-group', 'map_tooltip');
    }

    /**
     * Map Shortcode
     * @param type $atts
     * @return type
     */
    public function interactiveMapShortcode($atts)
    {

        return '<div id=vmap></div>';
    }
}

?>