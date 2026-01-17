<?php

if (! defined('ABSPATH')) {
    exit;
}

class WPBTM_Cron_Runner
{

    const CRON_HOOK = 'wpbtm_run_task';

    /** @var WPBTM_Task_Manager */
    protected $task_manager;

    /** @var WPBTM_Logger */
    protected $logger;

    public function __construct(WPBTM_Task_Manager $task_manager, WPBTM_Logger $logger)
    {
        $this->task_manager = $task_manager;
        $this->logger       = $logger;
    }

    /**
     * Register cron hook.
     */
    public function init()
    {
        add_action(self::CRON_HOOK, array($this, 'run'));
    }

    /**
     * Schedule cron if not already scheduled.
     */
    public function schedule()
    {
        if (! wp_next_scheduled(self::CRON_HOOK)) {
            wp_schedule_single_event(time() + 5, self::CRON_HOOK);
        }
    }

    /**
     * Execute one batch of the task.
     */
    public function run()
    {

        $state = $this->task_manager->get_state();

        if (! $this->task_manager->is_running($state)) {
            return;
        }

        // Simulate processing one unit of work.
        $this->logger->log(
            sprintf(
                'Processing step %d of %d',
                $state['current_step'] + 1,
                $state['total_steps']
            )
        );

        $this->task_manager->increment();

        $state = $this->task_manager->get_state();

        if ($this->task_manager->is_running($state)) {
            $this->schedule();
        } else {
            $this->logger->log('Task finished with status: ' . $state['status']);
        }
    }

    /**
     * Unschedule any pending cron event.
     */
    public function unschedule()
    {
        $timestamp = wp_next_scheduled(self::CRON_HOOK);

        if ($timestamp) {
            wp_unschedule_event($timestamp, self::CRON_HOOK);
        }
    }
}
