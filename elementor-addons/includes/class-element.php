<?php
namespace ThemePuller;

class Element {
    public function __construct() {   
        add_action('elementor/widgets/widgets_registered', array($this, 'widgets_registered'));
    }
    public function widgets_registered() {
        if (defined('THEMEPULLER_ELEMENTOR_PATH') && class_exists('Elementor\Widget_Base')) {
            require_once THEMEPULLER_ELEMENTOR_INCLUDES . '/widgets/pomodoro-timer.php';
        }
    }
}
