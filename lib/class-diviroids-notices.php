<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Class handles notice functionality for this plugin.
 *
 * @package    DiviRoids\Lib\DiviRoids_Notices
 * @since      1.0.0
*/

if (!class_exists('DiviRoids_Notices')) :

class DiviRoids_Notices extends DiviRoids_Instance_Base
{

    #region Constants

    const ERROR = 'error';
    const WARNING = 'warning';
    const SUCCESS = 'success';
    const INFO = 'info';

    #endregion

    #region Variables

    private $types = [];

    #endregion

    #region Constructors and Destructors

    /**
     * Class constructor and initializer.
     *
     * @since				1.0.0
     * @access protected
     * @param string $key
     * @param string $title
     * @param string $message
     * @param mixed $type
     */
    protected function initialization()
    {
        $this->name = 'notices';
        $this->hook = DIVIROIDS_PLUGIN_HOOK . '_' . $this->name;
        $this->slug = DIVIROIDS_PLUGIN_SLUG . '-' . $this->name;

        $this->types = [
            self::INFO,
            self::SUCCESS,
            self::WARNING,
            self::ERROR
        ];

        // Hook into the actions
        add_action('admin_notices', array( $this, 'render' ));
    }

    #endregion


    #region Private Functions

    /**
     * Creates the notification message
     *
     * @access private
     * @param  mixed $notice
     * @return array notice output
     */
    private function create($title, $message, $type)
    {
        $notice = [
                  'title'   => $title,
                  'message' => $message,
                  'type'    => in_array($type, $this->types) ? $type : SELF::INFO
              ];

        return $notice;
    }

    /**
     * Formats the notification
     *
     * @access private
     * @param  mixed $notice
     * @return string html output
     */
    private function format($notice)
    {
        $class  = sprintf(
                  'notice notice-%1$s %2$s',
                  $notice['type'],
                  $notice['type'] !== self::ERROR ? 'is-dismissible' : ''
                );

        $html   = sprintf(
                  '<div class="%1$s"><strong>%2$s</strong><p>%3$s</p></div>',
                  esc_attr($class),
                  isset($notice['title']) ? $notice['title'] : '',
                  $notice['message']
                );


        return $html;
    }

    #endregion

    #region Public Functions

    /**
     * Add a new error notification to the queue
     *
     * @param string $key
     * @param string $title
     * @param string $message
     */
    public function error($key, $title, $message)
    {
        $notice = $this->create($title, $message, SELF::ERROR);
        $this->save($key, $notice);
    }

    /**
     * Add a new warning notification to the queue
     *
     * @param string $key
     * @param string $title
     * @param string $message
     */
    public function warning($key, $title, $message)
    {
        $notice = $this->create($title, $message, SELF::WARNING);
        $this->save($key, $notice);
    }

    /**
     * Add a new success notification to the queue
     *
     * @param string $key
     * @param string $title
     * @param string $message
     */
    public function success_old($key, $title, $message)
    {
        $notice = $this->create($title, $message, SELF::SUCCESS);
        $this->save($key, $notice);
    }

    /**
     * Renders Success Notice
     *
     * @param string $title
     * @param string $message
     * @param string $output_to_stream
     */
    public function success($title, $message, $output_to_stream = true)
    {
        $notice = $this->create($title, $message, SELF::SUCCESS);

        if (!$output_to_stream) {
            return sprintf($this->format($notice));
        }

        printf($this->format($notice));
    }


    /**
     * Add a new info notification to the queue
     *
     * @param string $key
     * @param string $title
     * @param string $message
     */
    public function info($key, $title, $message)
    {
        $notice = $this->create($title, $message, SELF::INFO);
        $this->save($key, $notice);
    }

    /**
     * Gets the notifications
     *
     * @access public
     * @param  string $key
     * @return array notice output
     */
    public function get($key = null, $delete_on_retrieve = false)
    {
        $notices = get_transient($this->slug);

        if (empty($notices)) {
            $notices = [];
        }

        $notices = isset($notices, $notices[ $key ]) ? $notices[ $key ] : $notices;

        if ($delete_on_retrieve) {
            $this->remove($key);
        }

        return $notices;
    }

    /**
     * Save the notification
     *
     * @access public
     */
    public function save($key, $notice)
    {
        $notices = get_transient($this->slug);
        $notices[$key] = $notice;
        set_transient($this->slug, $notices);
    }

    /**
     * Removes the notifications
     *
     * @access public
     * @param  string $key
     */
    public function remove($key = null)
    {
        $notices = get_transient($this->slug);

        if (empty($notices)) {
            $notices = [];
        }

        $notices = isset($notices, $notices[ $key ]) ? $notices[ $key ] : $notices;

        set_transient($this->slug, $notices);
    }

    /**
     * Render one or all notices from previous page load.
     *
     * @param string|null $key
     */
    public function render($key = null)
    {
        // retrieve and remove
        $notices = $this->get($key, false);

        // We render all notices by default, unless a specific key is passed.
        $notices = isset($notices, $notices[ $key ]) ? $notices[ $key ] : $notices;

        // Loop through and render all notices
        if ($notices && is_array($notices)) {
            foreach ($notices as $key => $notice) {
                printf($this->format($notice));
            }
        }
    }

    #endregion
}

/**
 * Returns instance of this object
 *
 * @since 1.0.0
 */
function DiviRoids_Notices()
{
    return DiviRoids_Notices::getInstance();
}

endif;

// self initialize
DiviRoids_Notices();
