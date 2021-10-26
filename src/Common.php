<?php

namespace Main;

use Main\EmployeeBlock\BlockRender;
use const Main\EMPLOYEE_BLOCK_PLUGIN_FILE;

class Common
{
    public function __construct()
    {
        // Initialize Employee Block
        $this->block =  new BlockRender();
    }

    public function enqueueStyles()
    {
        $this->block->enqueueStyles();
    }

    public function enqueueScripts()
    {
        wp_enqueue_script(
            'common-scripts',
            plugin_dir_url(EMPLOYEE_BLOCK_PLUGIN_FILE) . '/assets/js/common.js'
        );
    }
}