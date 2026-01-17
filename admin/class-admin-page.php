<?php

if (! defined('ABSPATH')) {
    exit;
}

class WPBTM_Admin_Page
{

    /** @var WPBTM_Task_Manager */
    protected $task_manager;

    /** @var WPBTM_Cron_Runner */
    protected $cron_runner;

    public function __construct(WPBTM_Task_Manager $task_manager, WPBTM_Cron_Runner $cron_runner)
    {
        $this->task_manager = $task_manager;
        $this->cron_runner  = $cron_runner;
    }

    public function init()
    {
        add_action('admin_menu', array($this, 'register_menu'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_assets'));

        add_action('wp_ajax_wpbtm_start_task', array($this, 'ajax_start_task'));
        add_action('wp_ajax_wpbtm_cancel_task', array($this, 'ajax_cancel_task'));
    }

    public function register_menu()
    {
        add_management_page(
            'Background Task Demo',
            'Background Task Demo',
            'manage_options',
            'wpbtm',
            array($this, 'render_page')
        );
    }

    public function enqueue_assets($hook)
    {
        if ('tools_page_wpbtm' !== $hook) {
            return;
        }

        wp_enqueue_script(
            'wpbtm-admin',
            WPBTM_PLUGIN_URL . 'admin/assets/admin.js',
            array('jquery'),
            WPBTM_VERSION,
            true
        );

        wp_localize_script(
            'wpbtm-admin',
            'WPBTM',
            array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce'    => wp_create_nonce('wpbtm_nonce'),
            )
        );
    }

    public function render_page()
    {

        $state = $this->task_manager->get_state();
?>
        <div class="wrap">
            <h1>Background Task Demo</h1>

            <p>This page demonstrates a simple, chunked background task using WP-Cron.</p>

            <p>
                <button class="button button-primary" id="wpbtm-start">Start Task</button>
                <button class="button" id="wpbtm-cancel">Cancel Task</button>
            </p>

            <h2>Status</h2>
            <pre><?php echo esc_html(print_r($state, true)); ?></pre>
        </div>
<?php
    }

    public function ajax_start_task()
    {

        check_ajax_referer('wpbtm_nonce', 'nonce');

        if (! current_user_can('manage_options')) {
            wp_send_json_error('Permission denied');
        }

        $this->task_manager->start(5);
        $this->cron_runner->schedule();

        wp_send_json_success();
    }

    public function ajax_cancel_task()
    {

        check_ajax_referer('wpbtm_nonce', 'nonce');

        if (! current_user_can('manage_options')) {
            wp_send_json_error('Permission denied');
        }

        $this->task_manager->cancel();
        $this->cron_runner->unschedule();

        wp_send_json_success();
    }
}
