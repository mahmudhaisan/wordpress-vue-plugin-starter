<?php
namespace WpVue\Starter\Admin;

class Admin
{

    /**
     * Construct Function
     */
    public function __construct()
    {
        add_action('admin_menu', [$this, 'admin_menu']);
        add_action('admin_enqueue_scripts', [$this, 'register_scripts_styles']);
    }

    public function register_scripts_styles()
    {
        $this->load_scripts();
        $this->load_styles();
    }

    /**
     * Load Scripts
     *
     * @return void
     */
    public function load_scripts()
    {
        wp_register_script('wpvue-manifest', WPVUE_STARTER_URL . 'assets/js/manifest.js', [], rand(), true);
        wp_register_script('wpvue-vendor', WPVUE_STARTER_URL . 'assets/js/vendor.js', ['wpvue-manifest'], rand(), true);
        wp_register_script('wpvue-admin', WPVUE_STARTER_URL . 'assets/js/admin.js', ['wpvue-vendor'], rand(), true);

        wp_enqueue_script('wpvue-manifest');
        wp_enqueue_script('wpvue-vendor');
        wp_enqueue_script('wpvue-admin');

        wp_localize_script('wpvue-admin', 'wpvkAdminLocalizer', [
            'adminUrl' => admin_url('/'),
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'apiUrl' => home_url('/wp-json'),
        ]);
    }

    public function load_styles()
    {
        wp_register_style('wpvue-admin', WPVUE_STARTER_URL . 'assets/css/admin.css');

        wp_enqueue_style('wpvue-admin');
    }

    /**
     * Register Menu Page
     * @since 1.0.0
     */
    public function admin_menu()
    {
        global $submenu;

        $capability = 'manage_options';
        $slug = 'wp-vue-kickstart';

        $hook = add_menu_page(
            __('WP Vue Kickstart', 'textdomain'),
            __('WP Vue Kickstart', 'textdomain'),
            $capability,
            $slug,
            [$this, 'menu_page_template'],
            'dashicons-buddicons-replies'
        );

        if (current_user_can($capability)) {
            $submenu[$slug][] = [__('WpVue', 'textdomain'), $capability, 'admin.php?page=' . $slug . '#/'];
            $submenu[$slug][] = [__('Settings', 'textdomain'), $capability, 'admin.php?page=' . $slug . '#/settings'];
        }

        // add_action( 'load-' . $hook, [ $this, 'init_hooks' ] );
    }

    /**
     * Init Hooks for Admin Pages
     * @since 1.0.0
     */
    public function init_hooks()
    {
        add_action('admin_enqueu_scripts', [$this, 'enqueue_scripts']);
    }

    /**
     * Load Necessary Scripts & Styles
     * @since 1.0.0
     */
    public function enqueue_scripts()
    {
        wp_enqueue_style('wpvue-admin');
        wp_enqueue_script('wpvue-admin');
    }

    /**
     * Render Admin Page
     * @since 1.0.0
     */
    public function menu_page_template()
    {
        echo '<div class="wrap"><div id="wpvk-admin-app"></div></div>';
    }

}