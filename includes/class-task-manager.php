<?php

if (! defined('ABSPATH')) {
    exit;
}

class WPBTM_Task_Manager
{

    const OPTION_KEY = 'wpbtm_task_state';

    /**
     * Start a new task.
     *
     * @param int $total_steps
     * @return bool
     */
    public function start($total_steps)
    {

        $total_steps = absint($total_steps);

        if ($total_steps <= 0) {
            return false;
        }

        $state = array(
            'status'       => 'running',
            'current_step' => 0,
            'total_steps'  => $total_steps,
            'started_at'   => time(),
            'updated_at'   => time(),
        );

        update_option(self::OPTION_KEY, $state, false);

        return true;
    }

    /**
     * Mark the task as cancelled.
     *
     * @return void
     */
    public function cancel()
    {

        $state = $this->get_state();

        if (empty($state)) {
            return;
        }

        $state['status']     = 'cancelled';
        $state['updated_at'] = time();

        update_option(self::OPTION_KEY, $state, false);
    }

    /**
     * Advance task progress by one step.
     *
     * @return void
     */
    public function increment()
    {

        $state = $this->get_state();

        if (! $this->is_running($state)) {
            return;
        }

        $state['current_step']++;
        $state['updated_at'] = time();

        if ($state['current_step'] >= $state['total_steps']) {
            $state['status'] = 'completed';
        }

        update_option(self::OPTION_KEY, $state, false);
    }

    /**
     * Get current task state.
     *
     * @return array|null
     */
    public function get_state()
    {

        $state = get_option(self::OPTION_KEY);

        if (! is_array($state)) {
            return null;
        }

        return $state;
    }

    /**
     * Check if a task is currently running.
     *
     * @param array|null $state
     * @return bool
     */
    public function is_running($state = null)
    {

        if (null === $state) {
            $state = $this->get_state();
        }

        return (
            is_array($state) &&
            isset($state['status']) &&
            'running' === $state['status']
        );
    }

    /**
     * Clear task state completely.
     *
     * @return void
     */
    public function clear()
    {
        delete_option(self::OPTION_KEY);
    }
}
