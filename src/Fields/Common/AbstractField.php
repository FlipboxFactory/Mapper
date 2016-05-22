<?php

/**
 * Abstract Field
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

use Flipbox\Mapper\Identity\IdentityInterface;
use Flipbox\Mapper\Identity\IdentityTrait;
use Flipbox\Skeleton\Helpers\ArrayHelper;
use Flipbox\Skeleton\Object\AbstractObject;

abstract class AbstractField extends AbstractObject implements FieldInterface
{

    use SettingsTrait,
        IdentityTrait;

    /**
     * @var IdentityInterface
     */
    protected $_identity;

    /**
     * @var string Handle
     */
    public $handle;

    /**
     * @var string Name
     */
    public $name;

    /**
     * AbstractField constructor.
     * @param IdentityInterface $identity
     * @param $name
     * @param $handle
     * @param array $settings
     */
    public function __construct(IdentityInterface $identity, $name, $handle, $settings = [])
    {

        parent::__construct([
            'name' => (string)$name,
            'handle' => (string)$handle
        ]);

        $this->_identity = $identity;

        $this->setSettings($settings);

    }

    /**
     * @inheritdoc
     * @return static
     */
    public static function create($config = [])
    {

        $class = static::className();

        // Force array
        if (!is_array($config)) {
            $config = ArrayHelper::toArray($config, [], false);
        }

        return new $class(
            ArrayHelper::getValue($config, 'object',
                ArrayHelper::getValue($config, 'identity')
            ),
            ArrayHelper::getValue($config, 'name'),
            ArrayHelper::getValue($config, 'handle'),
            ArrayHelper::getValue($config, 'settings')
        );

    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @inheritdoc
     */
    public function getHandle()
    {
        return $this->handle;
    }

    /**
     * Get a non unique Name
     *
     * @return string
     */
    public function getConfiguration()
    {

        // Add class to config
        $class = static::configurationClassName();

        return new $class([
            'settings' => $this->getSettings()
        ]);

    }

}
