<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Class handles notice static functionality for this plugin.
 *
 * @package    DiviRoids\Lib\DiviRoids_Logger
 * @since      1.0.0
*/

if (!class_exists('DiviRoids_Logger')) :

class DiviRoids_Logger
{

    #region Constants

    const ALERT = 'ALERT';
    const CRITICAL = 'CRITICAL';
    const ERROR = 'ERROR';
    const WARNING = 'WARNING';
    const NOTICE = 'NOTICE';
    const INFO = 'INFO';
    const DEBUG = 'DEBUG';

    #endregion

    #region Private static functions

    /**
     * Checks to see if currently in debug mode.
     *
     * @access private
     *
     * @return boolean
     */
    private static function is_debug_mode()
    {
        return (defined('WP_DEBUG') && true === WP_DEBUG);
    }

    /**
     * Logs the message
     * @access private
     * @param  string $title
     * @param  string $message
     * @param  mixed $type
     */
    private static function log($title, $message, $type)
    {
        $message = self::format($title, $message, $type);
        error_log($message);
    }

    /**
     * formats the message
     * @access private
     * @param  string $title
     * @param  string $message
     * @param  mixed $type
     */
    private static function format($title, $message, $type)
    {
        $types = [
          self::ALERT,
          self::CRITICAL,
          self::ERROR,
          self::WARNING,
          self::NOTICE,
          self::INFO,
          self::DEBUG
      ];

        $type = in_array($type, $types) ? $type : '';
        $message = wp_strip_all_tags('[' . strtoupper($title) . '-' . $type . '] : ' . $message);
        return $message;
    }

    #endregion

    #region Public static functions

    /**
     * Logs a new alert message.
     *
     * @param string $key
     * @param string $title
     * @param string $message
     */
    public static function alert($title, $message)
    {
        self::log($title, $message, SELF::ALERT);
    }

    /**
     * Logs a new critical message.
     *
     * @param string $key
     * @param string $title
     * @param string $message
     */
    public static function critical($title, $message)
    {
        self::log($title, $message, SELF::CRITICAL);
    }

    /**
     * Logs a new error message.
     *
     * @param string $key
     * @param string $title
     * @param string $message
     */
    public static function error($title, $message)
    {
        self::log($title, $message, SELF::ERROR);
    }

    /**
     * Logs a new warning message.
     *
     * @param string $key
     * @param string $title
     * @param string $message
     */
    public static function warning($title, $message)
    {
        self::log($title, $message, SELF::WARNING);
    }

    /**
     * Logs a new notice message.
     *
     * @param string $key
     * @param string $title
     * @param string $message
     */
    public static function notice($title, $message)
    {
        self::log($title, $message, SELF::NOTICE);
    }

    /**
     * Logs a info notice message.
     *
     * @param string $key
     * @param string $title
     * @param string $message
     */
    public static function info($title, $message)
    {
        self::log($title, $message, SELF::INFO);
    }

    /**
     * Logs a debug notice message.
     *
     * @param string $key
     * @param string $title
     * @param string $message
     */
    public static function debug($title, $message)
    {
        self::log($title, $message, SELF::DEBUG);

        // Enable this during development
        /*
                if (self::is_debug_mode()) {
                    $message = self::format($title, $message, SELF::DEBUG);
                    echo PHP_EOL . $message . PHP_EOL;
                }
          */
    }

    #endregion
}

endif;
