<?php

if (! defined('ABSPATH')) {
    exit;
}

class WPBTM_Plugin
{

    protected $task_manager;
    protected $cron_runner;

    public function init()
    {

        $this->task_manager = new WPBTM_Task_Manager();
        $logger             = new WPBTM_Logger();

        $this->cron_runner = new WPBTM_Cron_Runner(
            $this->task_manager,
            $logger
        );

        $this->cron_runner->init();

        if (is_admin()) {
            $admin = new WPBTM_Admin_Page(
                $this->task_manager,
                $this->cron_runner
            );
            $admin->init();
        }
    }
}
