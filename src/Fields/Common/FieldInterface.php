<?php

/**
 * Field Interface
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

use Flipbox\Mapper\Object\ObjectInterface;

interface FieldInterface extends BaseInterface
{

    /**
     * Get a unique Handle
     *
     * @return string
     */
    public function getHandle();

    /**
     * Get a non unique Name
     *
     * @return string
     */
    public function getName();

    /**
     * Prepare a value for output
     *
     * @param $value
     * @param ObjectInterface $object
     * @return mixed
     */
    public function prepValueForOutput($value, ObjectInterface $object);

    /**
     * Prepare a value for input
     *
     * @param $value
     * @param ObjectInterface $object
     * @return mixed
     */
    public function prepValueForInput($value, ObjectInterface $object);

    /**
     * Get the associated field configuration
     *
     * @return ConfigurationInterface
     */
    public function getConfiguration();

    /**
     * Get the associated field configuration class name
     *
     * @return string
     */
    public static function configurationClassName();

}