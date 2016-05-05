<?php

/**
 * DateTime Field
 *
 * @package    Mapper
 * @author     Flipbox Factory <hello@flipboxfactory.com>
 * @copyright  2010-2016 Flipbox Digital Limited
 * @license    https://github.com/FlipboxFactory/Mapper/blob/master/LICENSE
 * @version    Release: 1.0.0
 * @link       https://github.com/FlipboxFactory/Mapper
 * @since      Class available since Release 1.0.0
 */

namespace Flipbox\Mapper\Fields\DateTime;

use Flipbox\Mapper\Fields\Common\AbstractField;
use Flipbox\Mapper\Object\ObjectInterface;

class Field extends AbstractField
{

    /**
     * @param $value
     * @param ObjectInterface $object
     * @return mixed
     */
    public function prepValueForOutput($value, ObjectInterface $object)
    {
        return (string)$value;
    }

    /**
     * @param $value
     * @param ObjectInterface $object
     * @return mixed
     */
    public function prepValueForInput($value, ObjectInterface $object)
    {
        return (string)$value;
    }

    /**
     * @return string
     */
    public static function settingsClassName()
    {
        return __NAMESPACE__ . '\\Settings';
    }

    /**
     * @return string
     */
    public static function configurationClassName()
    {
        return __NAMESPACE__ . '\\Configuration';
    }

}
