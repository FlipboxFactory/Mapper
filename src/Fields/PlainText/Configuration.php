<?php

/**
 * Plain Text Configuration
 *
 * @package    Mapper
 * @author     Flipbox Factory <hello@flipboxfactory.com>
 * @copyright  2010-2016 Flipbox Digital Limited
 * @license    https://github.com/FlipboxFactory/Mapper/blob/master/LICENSE
 * @version    Release: 1.0.2
 * @link       https://github.com/FlipboxFactory/Mapper
 * @since      Class available since Release 1.0.0
 */

namespace Flipbox\Mapper\Fields\PlainText;

use Flipbox\Mapper\Fields\Common\AbstractConfiguration;

class Configuration extends AbstractConfiguration
{

    /**
     * @return string
     */
    public static function getName()
    {
        return 'Plain Text';
    }

    /**
     * @return string
     */
    public static function fieldClassName()
    {
        return __NAMESPACE__ . '\\Field';
    }

    /**
     * @return string
     */
    protected static function settingsClassName()
    {
        return __NAMESPACE__ . '\\Settings';
    }

}
