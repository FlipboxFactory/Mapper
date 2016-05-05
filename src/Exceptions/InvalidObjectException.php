<?php

/**
 * Invalid Object Exception
 *
 * @package    Mapper
 * @author     Flipbox Factory <hello@flipboxfactory.com>
 * @copyright  2010-2016 Flipbox Digital Limited
 * @license    https://github.com/FlipboxFactory/Mapper/blob/master/LICENSE
 * @version    Release: 1.0.0
 * @link       https://github.com/FlipboxFactory/Mapper
 * @since      Class available since Release 1.0.0
 */

namespace Flipbox\Mapper\Exceptions;

class InvalidObjectException extends \Exception
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'Invalid Object Exception';
    }
}
