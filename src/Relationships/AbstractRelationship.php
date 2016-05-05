<?php

/**
 * Abstract Relationship
 *
 * @package    Mapper
 * @author     Flipbox Factory <hello@flipboxfactory.com>
 * @copyright  2010-2016 Flipbox Digital Limited
 * @license    https://github.com/FlipboxFactory/Mapper/blob/master/LICENSE
 * @version    Release: 1.0.0
 * @link       https://github.com/FlipboxFactory/Mapper
 * @since      Class available since Release 1.0.0
 */

namespace Flipbox\Mapper\Relationships;

use Flipbox\Mapper\Identity\IdentityInterface;
use Flipbox\Skeleton\Helpers\ArrayHelper;
use Flipbox\Skeleton\Object\AbstractObject;

abstract class AbstractRelationship extends AbstractObject implements RelationshipInterface
{

    /**
     * @var IdentityInterface
     */
    protected $_owner;

    /**
     * @var IdentityInterface
     */
    protected $_object;

    /**
     * @var string Handle
     */
    public $handle;

    /**
     * @var string Name
     */
    public $name;

    /**
     * AbstractRelationship constructor.
     * @param IdentityInterface $owner
     * @param IdentityInterface $object
     * @param $name
     * @param $handle
     */
    public function __construct(IdentityInterface $owner, IdentityInterface $object, $name, $handle)
    {

        parent::__construct([
            'name' => (string)$name,
            'handle' => (string)$handle
        ]);

        $this->_owner = $owner;
        $this->_object = $object;

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
            ArrayHelper::getValue($config, 'owner'),
            ArrayHelper::getValue($config, 'object'),
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
        return (string)$this->getHandle();
    }

}
