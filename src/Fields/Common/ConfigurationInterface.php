<?php

/**
 * Configuration Interface
 *
 * @package    Mapper
 * @author     Flipbox Factory <hello@flipboxfactory.com>
 * @copyright  2010-2016 Flipbox Digital Limited
 * @license    https://github.com/FlipboxFactory/Mapper/blob/master/LICENSE
 * @version    Release: 1.0.0
 * @link       https://github.com/FlipboxFactory/Mapper
 * @since      Class available since Release 1.0.0
 */

namespace Flipbox\Mapper\Fields\Common;

interface ConfigurationInterface extends BaseInterface
{

    /**
     * Returns the name of the field
     *
     * @return mixed
     */
    public static function getName();

    /**
     * Returns the field class name
     *
     * @return string
     */
    public static function fieldClassName();

    /**
     * Returns an array of types that this field is compatible with
     *
     * @return string
     */
    public static function getTypes();

    /**
     * Get input settings html (to configure the field)
     *
     * @return string|null
     */
    public function getSettingsHtml();

    /**
     * Prepares the settings for storage
     *
     * @return mixed
     */
    public function prepSettingsForStorage();

}
