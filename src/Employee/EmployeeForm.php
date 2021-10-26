<?php

namespace Main\Employee;

class EmployeeForm
{
    private $socials = ['GitHub', 'LinkedIn', 'Xing', 'Facebook'];

    public function __construct()
    {
        $this->init();
    }

    public function init()
    {
        add_action('add_meta_boxes', [$this, 'employeePosition']);
        add_action('add_meta_boxes', [$this, 'employeeShortDescription']);
        add_action('add_meta_boxes', [$this, 'employeeSocials']);
        add_action('save_post', [$this, 'employeesSave']);
    }

    public function employeePosition()
    {
        add_meta_box(
            'employee_position',
            'Position',
            [$this, 'employeePositionHtml'],
            'employees'
        );
    }

    public function employeeShortDescription()
    {
        add_meta_box(
            'employee_short_description',
            'Short Description',
            [$this, 'employeeShortDescriptionHtml'],
            'employees'
        );
    }

    public function employeeSocials()
    {
        add_meta_box(
            'employee_socials',
            'Socials',
            [$this, 'employeeSocialsHtml'],
            'employees'
        );
    }

    // Render Inputs
    private function inputHtml($value, $name, $label = null)
    {
        if (isset($label)) { ?>
            <label for="employee_<?php echo esc_attr($name) ?>"><?php echo esc_html($label) ?></label>
        <?php } ?>
        <input
                class="employee_input"
                name="employee_<?php echo esc_attr($name) ?>"
                value="<?php echo esc_attr($value) ?>"
        />
        <?php
    }

    // Renders Textarea
    private function textAreaHtml($value, $name)
    {
        ?>
        <textarea
                class="employee_input"
                name="employee_<?php echo esc_attr($name) ?>"
                maxlength="360"
        ><?php echo esc_attr($value) ?></textarea>
        <?php
    }

    public function employeePositionHtml($post)
    {
        $value = get_post_meta($post->ID, 'employee_position', true);
        $this->inputHtml($value, 'position');
    }

    public function employeeShortDescriptionHtml($post)
    {
        $value = get_post_meta($post->ID, 'employee_short_description', true);
        $this->textAreaHtml($value, 'short_description');
    }

    public function employeeSocialsHtml($post)
    {
        foreach ($this->socials as $social) {
            $label = $social;
            $value = get_post_meta($post->ID, 'employee_' . $social, true);
            $this->inputHtml($value, $social, $label);
        }
    }

    public function employeesSave($postId)
    {
        $post = wp_unslash($_POST);

        if (array_key_exists('employee_position', $post)) {
            update_post_meta(
                $postId,
                'employee_position',
                $post['employee_position']
            );
        }

        if (array_key_exists('employee_short_description', $post)) {
            update_post_meta(
                $postId,
                'employee_short_description',
                $post['employee_short_description']
            );
        }

        foreach ($this->socials as $social) {
            if (array_key_exists('employee_' . $social, $post)) {
                update_post_meta(
                    $postId,
                    'employee_' . $social,
                    $post[ 'employee_' . $social ]
                );
            }
        }
    }
}