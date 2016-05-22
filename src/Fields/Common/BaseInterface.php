<?php

/**
 * Base Interface
 *
 * This interface is intended to be used as the base for Field and Configuration interfaces.
 *
 * @package    Mapper
 * @author     Flipbox Factory <hello@flipboxfactory.com>
 * @copyright  2010-2016 Flipbox Digital Limited
 * @license    https://github.com/FlipboxFactory/Mapper/blob/master/LICENSE
 * @version    Release: 1.0.2
 * @link       https://github.com/FlipboxFactory/Mapper
 * @since      Class available since Release 1.0.0
 */

namespace Flipbox\Mapper\Fields\Common;

interface BaseInterface
{

    /**
     * Instantiates and populates a new field instance with the given set of properties.
     *
     * @param array $config
     * @return FieldInterface
     */
    public static function create($config = []);

    /**
     * Get the fully qualified name of this class.
     *
     * @return string
     */
    public static function className();

    /**
     * Get the field settings
     *
     * @return SettingsInterface
     */
    public function getSettings();

    /**
     * Set the field Settings
     *
     * @param null $settings
     * @return $this
     */
    public function setSettings($settings = null);

    /**
     * Get the field settings class name
     *
     * @return string
     */
    public static function settingsClassName();

}
