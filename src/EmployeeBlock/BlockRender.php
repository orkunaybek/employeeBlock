<?php

namespace Main\EmployeeBlock;

use Main\EmployeeBlock\BlockView;
use const Main\EMPLOYEE_BLOCK_PLUGIN_FILE;

class BlockRender
{
    public function __construct()
    {
        $this->includeAssets();
        add_action('init', [$this, 'registerEmployeeBlock']);
    }

    public function includeAssets()
    {
        $this->assetFile = include(plugin_dir_path(EMPLOYEE_BLOCK_PLUGIN_FILE) . 'build/index.asset.php');
    }

    public function enqueueStyles()
    {
        wp_enqueue_style(
            'employee-block',
            plugin_dir_url(EMPLOYEE_BLOCK_PLUGIN_FILE) . 'build/style-index.css',
            [],
            $this->assetFile['version']
        );
    }

    public function registerEmployeeBlock()
    {
        wp_register_script(
            'employees_block_script',
            plugins_url('build/index.js', EMPLOYEE_BLOCK_PLUGIN_FILE),
            $this->assetFile['dependencies'],
            $this->assetFile['version'],
            true
        );
        wp_register_style(
            'employees_block_style',
            plugins_url('build/style-index.css', EMPLOYEE_BLOCK_PLUGIN_FILE),
            [],
            $this->assetFile['version']
        );

        /* This script checks the url parameters at init hook to decide if post type is page,
         and only registers the block if it is page */

        if (is_admin()) {
            global $pagenow;
            $typenow = '';
            // checks for new post
            if ('post-new.php' === $pagenow) {
                if (isset($_REQUEST['post_type']) && post_type_exists($_REQUEST['post_type'])) {
                    $typenow = $_REQUEST['post_type'];
                };
                // checks for post update
            } elseif ('post.php' === $pagenow) {
                if (isset($_GET['post']) && isset($_POST['post_ID']) && (int)$_GET['post'] !== (int)$_POST['post_ID']) {
                    // Do nothing
                } elseif (isset($_GET['post'])) {
                    $post_id = (int)$_GET['post'];
                } elseif (isset($_POST['post_ID'])) {
                    $post_id = (int)$_POST['post_ID'];
                }
                if ($post_id) {
                    $post = get_post($post_id);
                    $typenow = $post->post_type;
                }
            }
            if ($typenow != 'page') {
                return;
            }
        }

        // Register the block
        wp_register_script(
            'my-custom-block',
            plugins_url('build/block.js', __FILE__),
            $this->assetFile['dependencies'],
            $this->assetFile['version']
        );
        register_block_type(
            'inpsyde/employee-block',
            [
                'api_version' => 2,
                'editor_script' => 'employees_block_script',
                'editor_style' => 'employees_block_style',
                'icon' => 'businessman',
                'attributes' => [
                    'blockPost' => [
                        'default' => 'empty',
                        'type' => 'string'
                    ],
                ],
                'render_callback' => [$this, 'getBlockData'],
            ]
        );
    }

    // Get post data using block attribute and returns the block view
    public function getBlockData($attributes)
    {
        $postId = $attributes['blockPost'];
        $post = get_post($postId);
        if ($post) {
            $image = get_the_post_thumbnail_url($postId);
            $position = get_post_meta($postId, 'employee_position', true);
            $description = get_post_meta($postId, 'employee_short_description', true);
            $socialContent = $this->getSocials($post);


            $view = new BlockView($post, $description, $position, $socialContent, $image);

            return $view->init();
        }
    }

    public function getSocials($post): array
    {
        $socials = ['GitHub', 'LinkedIn', 'Xing', 'Facebook'];
        $socialContent = [];
        foreach ($socials as $social) {
            $value = get_post_meta($post->ID, 'employee_' . $social, true);
            $socialContent[ $social ] = $value;
        }

        return $socialContent;
    }
}