<?php

/**
 * Settings Interface
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

use Flipbox\Skeleton\Error\ErrorInterface;

interface SettingsInterface extends ErrorInterface
{

    /**
     * Populate the settings
     *
     * @param array $config
     * @return mixed
     */
    public function populate($config = []);

}