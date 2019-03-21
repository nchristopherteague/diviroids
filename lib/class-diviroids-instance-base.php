<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Base contains common singleton functionality.
 *
 * @package    DiviRoids\Lib\DiviRoids_Instance_Base
 * @since      1.0.0
*/

abstract class DiviRoids_Instance_Base
{

    #region Variables

    /**
     * Instance name
     *
     * @var string
     */
    protected $name;

    /**
     * Instance slug
     *
     * @var string
     */
    protected $slug;

    /**
     * Instance hook
     *
     * @var string
     */
    protected $hook;

    /**
     * Instance dir
     *
     * @var string
     */
    protected $dir = null;

    /**
     * Instance of the parent calling class
     *
     * @var mixed $parent_instance instance of the calling parent
     */
    protected $parent_instance = null;

    /**
     *  holds an single instance of the child class
     *
     *  @var array of objects
     */
    protected static $instance = [];

    #endregion

    #region Constructors and Destructors

    /**
     * Parent constructor for the child class
     *
     * @since  1.0.0
     * @access protected
     */
    protected function __construct()
    {
        // TODO: For now, this will stay blank.
      // The future may hold a different direction
    }

    /**
     * Force consumers to initialize the class and set its properties.
     *
     * @since  1.0.0
     * @access protected
     */
    abstract protected function initialization();

    /**
     *  @desc provides a single slot to hold an instance interchanble between all child classes.
     *  @return object
     */
    public static function getInstance()
    {
        $class = get_called_class();

        if (!isset(self::$instance[$class]) || !self::$instance[$class] instanceof $class) {
            self::$instance[$class] = new $class(); // create and instance of child class which extends Singleton super class
            self::$instance[$class]->initialization(); // Initialize the class
        }

        return static::$instance[$class];
    }

    #endregion

    #region Private Functions

    /**
     * Make clone magic method private, so nobody can clone instance.
     */
    private function __clone()
    {
        _doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?'), DIVIROIDS_PLUGIN_VERSION);
    }

    /**
     * Make sleep magic method private, so nobody can serialize instance.
     */
    private function __sleep()
    {
        _doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?'), DIVIROIDS_PLUGIN_VERSION);
    }

    /**
     * Make wakeup magic method private, so nobody can unserialize instance.
     */
    private function __wakeup()
    {
        _doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?'), DIVIROIDS_PLUGIN_VERSION);
    }

    #endregion
}
