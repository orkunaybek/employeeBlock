<?php

namespace Main;

use Main\Admin;
use Main\Common;

class Plugin {
    public function __construct(){
        $this->init();
    }

    public function init(){
        $this->adminHooks();
        $this->commonHooks();
    }

    public function adminHooks(){
        $admin = new Admin();
        add_action('admin_enqueue_scripts', [$admin, 'enqueueStyles']);
    }

    public function commonHooks() {
        $common = new Common();
        add_action('wp_footer', [$common, 'enqueueScripts']);
        add_action('wp_enqueue_scripts', [$common, 'enqueueStyles']);
    }

}
