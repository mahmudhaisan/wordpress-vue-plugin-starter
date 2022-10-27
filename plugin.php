<?php

/**
 * Plugin Name: Wp Vue Starter Plugin
 * Plugin URI: https://github.com/mahmudhaisan
 * Description: Wordpress vue headless cms plugin
 * Version: 1.0
 * Author: Mahmud haisan
 * Author URI: https://github.com/mahmudhaisan
 * Developer: Mahmud Haisan
 * Developer URI: https://github.com/mahmudhaisan
 * Text Domain: wpvue493
 * Domain Path: /languages
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

if (!defined('ABSPATH')) {
    exit;
}

require_once 'vendor/autoload.php';

/**
 * The Main Plugin Class
 */

final class Wp_Vue_Starter_Class
{

    /**
     *  * plugin version
     * @var string
     */
    const VERSION = '1.0';

    /**
     * Class Constructor
     */
    private function __construct()
    {
        $this->define_Plugin_comstants();
        register_activation_hook(__FILE__, [$this, 'activate']); // activation hook
        add_action('plugins_loaded', [$this, 'init_plugin']); //plugin init
    }

    /**
     * Initialize Singleton Instance
     */
    public static function init()
    {
        static $instance = false;

        if (!$instance) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Define Plugin Constants
     */
    public function define_Plugin_comstants()
    {
        define('WPVUE_STARTER_VERSION', self::VERSION);
        define('WPVUE_STARTER_FILE', __FILE__);
        define('WPVUE_STARTER_PATH', __DIR__);
        define('WPVUE_STARTER_URL', plugins_url('', WPVUE_STARTER_FILE));
        define('WPVUE_STARTER_ASSETS', WPVUE_STARTER_URL . '/assets');
    }

    /**
     * plugin activation callback function
     *
     * @return void
     */
    public function activate()
    {

        update_option('wp_vue_version', WPVUE_STARTER_VERSION);
    }

    /**
     * plugins activity after activating the plugin
     *
     * @return plugins basic things
     */
    public function init_plugin()
    {
        if (is_admin()) {
            new WpVue\Starter\Admin\Admin;
        }

        // Api Init
        new WpVue\Starter\Api\Api;

    }
}

/**
 * Initialize Main Plugin
 *
 * @return \wp_vue_Class
 */

function wp_vue()
{
    return Wp_Vue_Starter_Class::init();
}

// calling the main class instance
wp_vue();