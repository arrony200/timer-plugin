<?php
namespace ThemePuller;

class Scripts {

    public function __construct() {
        add_action('elementor/preview/after_register_styles', array($this, 'required_assets'));
        add_action('elementor/frontend/after_register_scripts', array($this, 'required_script'));
    }

    public function required_script() {
     wp_enqueue_script( 'themepuller-charming-script', plugins_url( 'assets/js/addons-script.js', __FILE__ ), array('jquery'), false, true  );
    }

    public function required_assets() {
        
    }

}
