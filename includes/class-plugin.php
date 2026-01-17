<?php

if (! defined('ABSPATH')) {
    exit;
}

class WPBTM_Plugin
{

    /** @var WPBTM_Task_Manager */
    protected $task_manager;

    /** @var WPBTM_Cron_Runner */
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
    }
}
