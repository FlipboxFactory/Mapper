<?php

/**
 * Settings Trait
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

trait SettingsTrait
{

    /**
     * The settings
     *
     * @var SettingsInterface
     */
    protected $_settings;

    /**
     * @return string
     */
    protected abstract static function settingsClassName();

    /**
     * Get the settings
     *
     * @return SettingsInterface
     */
    public function getSettings()
    {

        if (!$this->_settings instanceof SettingsInterface) {

            $this->_settings = $this->createSettings();

        }

        return $this->_settings;

    }

    /**
     * Set the settings
     *
     * @param null $settings
     * @return $this
     */
    public function setSettings($settings = null)
    {

        if (!$settings instanceof SettingsInterface) {

            $this->getSettings()
                ->populate($settings);

        } else {

            $this->_settings = $settings;

        }

        return $this;

    }

    /**
     * Create a settings object and populate it
     *
     * @param array $config
     * @return SettingsInterface
     */
    protected function createSettings($config = [])
    {

        $settingsClass = static::settingsClassName();

        /** @var SettingsInterface $settings */
        $settings = new $settingsClass();

        if (!empty($config)) {
            $settings->populate($settings);

        }

        return $settings;

    }

}