<?php

if (! defined('ABSPATH')) {
    exit;
}

class WPBTM_Logger
{

    protected $log_file;

    public function __construct()
    {
        $upload_dir    = wp_upload_dir();
        $this->log_file = trailingslashit($upload_dir['basedir']) . 'wpbtm.log';
    }

    /**
     * Write a log line.
     *
     * @param string $message
     */
    public function log($message)
    {
        $line = sprintf(
            "[%s] %s\n",
            date('Y-m-d H:i:s'),
            $message
        );

        file_put_contents($this->log_file, $line, FILE_APPEND);
    }
}
