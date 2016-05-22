<?php

/**
 * Abstract Field Configuration
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

use Flipbox\Skeleton\Helpers\ArrayHelper;
use Flipbox\Skeleton\Object\AbstractObject;

abstract class AbstractConfiguration extends AbstractObject implements ConfigurationInterface
{

    use SettingsTrait;

    /**
     * @return array
     */
    public static function getTypes()
    {
        return [];
    }

    /**
     * @return string
     */
    public function getSettingsHtml()
    {
        return '';
    }

    /**
     * @return string
     */
    public function prepSettingsForStorage()
    {
        return ArrayHelper::toArray(
            $this->getSettings()
        );
    }

}
