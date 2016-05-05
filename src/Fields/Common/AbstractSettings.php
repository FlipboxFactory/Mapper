<?php

/**
 * Abstract Field Settings
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

use Flipbox\Skeleton\Error\ErrorTrait;
use Flipbox\Skeleton\Helpers\ArrayHelper;
use Flipbox\Skeleton\Object\AbstractObject;

abstract class AbstractSettings extends AbstractObject implements SettingsInterface
{

    use ErrorTrait;

    /**
     * @inheritdoc
     */
    public function populate($config = [])
    {

        // Force array
        if (!is_array($config)) {
            $config = ArrayHelper::toArray($config, [], false);
        }

        foreach ($config as $property => $value) {

            if ($this->canSetProperty($property)) {

                $this->$property = $value;

            }

        }

        return $this;

    }

}
