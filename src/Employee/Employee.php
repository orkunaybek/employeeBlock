<?php

namespace Main\Employee;

class Employee
{
    public function __construct()
    {
        $this->init();
    }

    public function init()
    {
        add_action('init', [$this, 'employee_post_type']);
    }

    public function employee_post_type()
    {
        register_post_type(
            'employees',
            [
                'labels' => [
                    'name' => 'Employees',
                    'singular_name' => 'Employee',
                ],
                'supports' => ['title', 'thumbnail'],
                'public' => true,
                'show_in_rest' => true,
                'menu_icon' => 'dashicons-businessman',
                'has_archive' => false,
                'publicly_queryable' => false,
            ]
        );
    }
}