<?php

/**
 * Abstract Identity
 *
 * @package    Mapper
 * @author     Flipbox Factory <hello@flipboxfactory.com>
 * @copyright  2010-2016 Flipbox Digital Limited
 * @license    https://github.com/FlipboxFactory/Mapper/blob/master/LICENSE
 * @version    Release: 1.0.2
 * @link       https://github.com/FlipboxFactory/Mapper
 * @since      Class available since Release 1.0.0
 */

namespace Flipbox\Mapper\Identity;

use Flipbox\Skeleton\Helpers\ArrayHelper;
use Flipbox\Skeleton\Object\AbstractObject;

abstract class AbstractIdentity extends AbstractObject implements IdentityInterface
{

    /**
     * @var string Handle
     */
    public $handle;

    /**
     * @var string Name
     */
    public $name;

    /**
     * Identity constructor.
     * @param $name
     * @param $handle
     */
    public function __construct($name, $handle)
    {
        parent::__construct([
            'name' => (string)$name,
            'handle' => (string)$handle
        ]);
    }

    /**
     * @param array $config
     * @return IdentityInterface
     */
    public static function create($config = [])
    {

        $class = static::className();

        return new $class(
            ArrayHelper::getValue($config, 'name'),
            ArrayHelper::getValue($config, 'handle')
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
     * @return string
     */
    public function __toString()
    {
        return (string)$this->name;
    }

}
