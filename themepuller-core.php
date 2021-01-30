<?php
/*
  Plugin Name: Timer Plugin
  Plugin URI: http://themepuller.com/
  Description: Helping for the wordpress site.
  Author: Themepuller
  Version: 1.0
  Author URI: http://themepuller.com/
*/

function themepuller_enqueue() {
    //wp_enqueue_style('bootstrapcdn-css',plugin_dir_url(__FILE__) . 'css/bootstrap.min.css','',time());
    wp_enqueue_style('pomodoro-timer-css', plugin_dir_url(__FILE__) . 'css/pomodoro-timer.css','',time());
    wp_enqueue_style('themepuller-css', plugin_dir_url(__FILE__) . 'css/themepuller.css','',time());

  wp_enqueue_script( 'pomodoro-timer' , plugin_dir_url(__FILE__) . 'js/pomodoro-timer.js' ,  array('jquery'), time(), true );
   wp_enqueue_script( 'themepuller' , plugin_dir_url(__FILE__) . 'js/themepuller.js' ,  array('jquery'), false, true );
   wp_localize_script( 
    'pomodoro-timer', 'plugindir_object',
    array( 
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'audio_url'=> plugin_dir_url( __FILE__ ) .'/sounds/',
    )
);

}
add_action('wp_enqueue_scripts', 'themepuller_enqueue');


define('PLUGIN_DIR', dirname(__FILE__) . '/');

if (!defined('THEMEPULLER_CORE_PLUGIN_URI')) {
    define('THEMEPULLER_CORE_PLUGIN_URI', plugin_dir_url(__FILE__));
}

if (!class_exists('ThemePuller')) {

    class ThemePuller {
        public static $plugindir, $pluginurl;
        function __construct() {
            ThemePuller::$plugindir = dirname(__FILE__);
            ThemePuller::$pluginurl = plugins_url('', __FILE__);
        }
    }

    $themepuller = new ThemePuller();
    require_once( ThemePuller::$plugindir . "/elementor-addons/themepuller-elementor.php" );

}