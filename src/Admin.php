<?php

namespace Main;

use Main\Employee\Employee;
use Main\Employee\EmployeeForm;
use const Main\EMPLOYEE_BLOCK_PLUGIN_FILE;

class Admin
{
    public function __construct()
    {
        $this->init();
    }

    // Initialize Employee post type
    public function init()
    {
        new Employee();
        new EmployeeForm();
    }

    public function enqueueStyles()
    {
        wp_enqueue_style('admin-styles', plugin_dir_url(EMPLOYEE_BLOCK_PLUGIN_FILE) . '/assets/css/admin.css');
    }
}