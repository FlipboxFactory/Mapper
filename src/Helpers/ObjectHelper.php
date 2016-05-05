<?php

/**
 * Object Helper
 *
 * @package    Mapper
 * @author     Flipbox Factory <hello@flipboxfactory.com>
 * @copyright  2010-2016 Flipbox Digital Limited
 * @license    https://github.com/FlipboxFactory/Mapper/blob/master/LICENSE
 * @version    Release: 1.0.0
 * @link       https://github.com/FlipboxFactory/Mapper
 * @since      Class available since Release 1.0.0
 */

namespace Flipbox\Mapper\Helpers;

use Flipbox\Mapper\Object\ObjectInterface;
use Flipbox\Skeleton\Helpers\ObjectHelper as SkeletonObjectHelper;

class ObjectHelper extends SkeletonObjectHelper
{

    /**
     * The input object scenario.  This is used when we're interacting with external 'name'.
     */
    const SCENARIO_INPUT = 'input';

    /**
     * The output object scenario.  This is used when we're interacting with internal 'handle'.
     */
    const SCENARIO_OUTPUT = 'output';

    /**
     * @param $object
     * @param $config
     * @return Object
     */
    public static function populate($object, $config)
    {

        if (!$object instanceof ObjectInterface) {

            $object = static::create($object);

        }

        // Populate model attributes
        if (is_array($config)) {

            // Set by name not handle
            $attributes = array_flip($object->getAliasDefinition());

            foreach ($config as $name => $value) {

                if (isset($attributes[$name])) {

                    $object->$name = $value;

                }

            }

        }

        return $object;

    }

}