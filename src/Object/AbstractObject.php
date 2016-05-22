<?php

/**
 * Abstract Object
 *
 * @package    Mapper
 * @author     Flipbox Factory <hello@flipboxfactory.com>
 * @copyright  2010-2016 Flipbox Digital Limited
 * @license    https://github.com/FlipboxFactory/Mapper/blob/master/LICENSE
 * @version    Release: 1.0.2
 * @link       https://github.com/FlipboxFactory/Mapper
 * @since      Class available since Release 1.0.0
 */

namespace Flipbox\Mapper\Object;

use ArrayIterator;
use Flipbox\Mapper\Fields\Common\FieldInterface;
use Flipbox\Mapper\Helpers\ObjectHelper;
use Flipbox\Mapper\Identity\IdentityInterface;
use Flipbox\Mapper\Identity\IdentityTrait;
use Flipbox\Mapper\Relationships\RelationshipInterface;
use Flipbox\Skeleton\Error\ErrorTrait;
use Flipbox\Skeleton\Exceptions\InvalidCallException;
use Flipbox\Skeleton\Exceptions\UnknownMethodException;
use Flipbox\Skeleton\Exceptions\UnknownPropertyException;
use Flipbox\Skeleton\Helpers\ArrayHelper;
use Flipbox\Skeleton\Object\AbstractObject as CommonAbstractObject;
use IteratorAggregate;

abstract class AbstractObject extends CommonAbstractObject implements IteratorAggregate, ObjectInterface
{

    use IdentityTrait, IdTrait;
    use ErrorTrait {
        addError as _traitAddError;
    }

    /**
     * @var array of prepared property values
     */
    protected $_preparedOutput = [];

    /**
     * @var array of prepared property values
     */
    protected $_preparedInput = [];

    /**
     * @var array of raw property values
     */
    protected $_raw = [];

    /**
     * The current scenario
     *
     * @var string
     */
    protected $_scenario = ObjectHelper::SCENARIO_OUTPUT;

    /**
     * OutputObject constructor.
     * @param IdentityInterface $identity
     * @param array $config
     */
    public function __construct(IdentityInterface $identity, $config = [])
    {

        // Set identity
        $this->_identity = $identity;

        // Populate
        if (!empty($config)) {
            $this->populate($config);
        }

        $this->init();

    }

    /**
     * @param array $config
     * @return mixed
     */
    public static function create($config = [])
    {

        // Force array
        if (!is_array($config)) {
            $config = ArrayHelper::toArray($config, [], false);
        }

        // Add class to config
        $class = static::className();

        return new $class(
            ArrayHelper::remove($config, 'identity'),
            $config
        );

    }


    /*******************************************
     * POPULATE
     *******************************************/

    /**
     * @param array $properties
     * @return $this
     */
    public function populate($properties = [])
    {

        // Force array
        if (!is_array($properties)) {
            $properties = ArrayHelper::toArray($properties, [], false);
        }

        foreach ($properties as $name => $value) {

            // Hijack the Id
            if (strtolower($name) === 'id') {

                $this->setId($value);

            } elseif ($handle = $this->resolveDynamicPropertyHandle($name)) {

                // Set raw value (with handle key)
                $this->_raw[$handle] = $value;

                // Remove from prepared
                ArrayHelper::remove($this->_preparedOutput, $handle);

            }

        }

        return $this;

    }

    /**
     * If in input scenario, make sure the handle exists -- otherwise convert to handle
     *
     * @param $name
     * @return null
     */
    protected function resolveDynamicPropertyHandle($name)
    {

        if ($this->inInputScenario()) {

            // Does handle exist
            if ($this->hasDynamicHandle($name)) {

                return $name;

            } else {

                return null;

            }

        }

        return $this->toDynamicHandle($name);

    }

    /*******************************************
     * ALIAS DEFINITIONS
     *******************************************/

    /**
     * @param array $attributes
     * @return mixed
     */
    public function getAliasDefinition(array $attributes = [])
    {
        return array_merge(
            $this->getFieldAliasDefinition($attributes),
            $this->getChildRelationshipAliasDefinition($attributes),
            $this->getParentRelationshipAliasDefinition($attributes)
        );
    }

    /**
     * An array of attribute name => alias definitions
     *
     * @param array $attributes
     * @return FieldInterface[]
     */
    public function getFieldAliasDefinition(array $attributes = [])
    {
        return ArrayHelper::matches(
            $attributes,
            ArrayHelper::map(
                $this->findDynamicFieldProperties(),
                'handle',
                'name'
            )
        );
    }

    /**
     * An array of attribute name => alias definitions
     *
     * @param array $attributes
     * @return RelationshipInterface[]
     */
    public function getChildRelationshipAliasDefinition(array $attributes = [])
    {
        return ArrayHelper::matches(
            $attributes,
            ArrayHelper::map(
                $this->findDynamicChildRelationshipProperties(),
                'handle',
                'name'
            )
        );
    }

    /**
     * An array of attribute name => alias definitions
     *
     * @param array $attributes
     * @return RelationshipInterface[]
     */
    public function getParentRelationshipAliasDefinition(array $attributes = [])
    {
        return ArrayHelper::matches(
            $attributes,
            ArrayHelper::map(
                $this->findDynamicParentRelationshipProperties(),
                'handle',
                'name'
            )
        );
    }




    /*******************************************
     * TRAVERSABLE
     *******************************************/


    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->getOutputValues());
    }

    /*******************************************
     * OUTPUT
     *******************************************/

    /**
     * @inheritdoc
     */
    public function getOutputValues(array $attributes = [])
    {

        $values = [
            'Id' => $this->getId()
        ];

        foreach ($this->getAliasDefinition($attributes) as $handle => $name) {

            $values[$handle] = $this->_prepareDynamicOutputProperty($handle);

        }

        return ArrayHelper::matches($attributes, $values);

    }

    /**
     * @param $name
     * @return mixed
     */
    protected function _prepareDynamicOutputProperty($name)
    {
        // Already prepared?
        if (!array_key_exists($name, $this->_preparedOutput)) {

            /** @var FieldInterface|RelationshipInterface $property */
            if ($property = $this->findDynamicProperty($name)) {

                $this->_preparedOutput[$name] = $property->prepValueForOutput(
                    ArrayHelper::getValue($this->_raw, $name),
                    $this
                );

            } else {

                // todo - Log this
                $this->_preparedOutput[$name] = null;

            }

        }

        return $this->_preparedOutput[$name];

    }

    /*******************************************
     * INPUT
     *******************************************/

    /**
     * @param array $attributes
     * @return array
     */
    public function getInputValues(array $attributes = [])
    {

        if (empty($attributes)) {
            $attributes = array_keys($this->_raw);
        }

        // Get fields only
        $dynamicFields = array_flip($this->getFieldAliasDefinition());

        // Match with attributes (if applicable)
        if (!empty($attributes)) {

            $dynamicFields = array_intersect(
                $dynamicFields,
                $attributes
            );

        }

        $values = array();

        foreach ($dynamicFields as $name => $handle) {

            $values[$name] = $this->_prepareDynamicInputProperty($handle);

        }

        return $values;

    }

    /**
     * @param $name
     * @return mixed
     */
    protected function _prepareDynamicInputProperty($name)
    {
        // Already prepared?
        if (!array_key_exists($name, $this->_preparedInput)) {

            /** @var FieldInterface|RelationshipInterface $property */
            if ($property = $this->findDynamicProperty($name)) {

                $this->_preparedInput[$name] = $property->prepValueForInput(
                    ArrayHelper::getValue($this->_raw, $name),
                    $this
                );

            } else {

                // todo - Log this
                $this->_preparedInput[$name] = null;

            }

        }

        return $this->_preparedInput[$name];

    }

    /*******************************************
     * DYNAMIC PROPERTIES
     *******************************************/

    /**
     * @inheritdoc
     */
    protected function findDynamicProperties($indexBy = null)
    {
        return array_merge(
            $this->findDynamicFieldProperties($indexBy),
            $this->findDynamicChildRelationshipProperties($indexBy),
            $this->findDynamicParentRelationshipProperties($indexBy)
        );
    }

    /**
     * @param null $indexBy
     * @return FieldInterface[]
     */
    protected function findDynamicFieldProperties($indexBy = null)
    {
        return [];
    }

    /**
     * @param null $indexBy
     * @return RelationshipInterface[]
     */
    protected function findDynamicChildRelationshipProperties($indexBy = null)
    {
        return [];
    }

    /**
     * @param null $indexBy
     * @return RelationshipInterface[]
     */
    protected function findDynamicParentRelationshipProperties($indexBy = null)
    {
        return [];
    }


    /*******************************************
     * DYNAMIC PROPERTY UTILITIES
     *******************************************/

    /**
     * @param $handle
     * @return FieldInterface|RelationshipInterface|null
     */
    protected function findDynamicProperty($handle)
    {
        return ArrayHelper::getValue(
            $this->findDynamicProperties('handle'),
            $handle
        );
    }

    /**
     * @param $name
     * @return bool
     */
    protected function toDynamicHandle($name)
    {
        return ArrayHelper::getValue(
            array_flip($this->getAliasDefinition()),
            $name
        );
    }

    /**
     * @param $handle
     * @return bool
     */
    protected function toDynamicName($handle)
    {
        return ArrayHelper::getValue(
            $this->getAliasDefinition(),
            $handle
        );
    }

    /**
     * @param $handle
     * @return bool
     */
    protected function isDynamicHandle($handle)
    {
        return array_key_exists($handle, $this->getAliasDefinition());
    }

    /**
     * @param $name
     * @return bool
     */
    protected function isDynamicName($name)
    {
        return !in_array($name, $this->getAliasDefinition());
    }

    /**
     * @param $name
     * @return bool
     */
    protected function hasDynamicHandle($name)
    {
        return $this->isDynamicName($name);
    }

    /**
     * @param $handle
     * @return bool
     */
    protected function hasDynamicName($handle)
    {
        return $this->isDynamicHandle($handle);
    }

    /*****************************************************
     * SCENARIO
     *****************************************************/

    /**
     * Get the current scenario
     *
     * @return string
     */
    protected function getScenario()
    {
        return $this->_scenario;
    }

    /**
     * Set the current scenario
     *
     * @param $scenario
     * @return $this
     */
    protected function setScenario($scenario)
    {

        if (ObjectHelper::SCENARIO_INPUT == $scenario) {

            $this->_scenario = ObjectHelper::SCENARIO_INPUT == $scenario ? ObjectHelper::SCENARIO_INPUT : ObjectHelper::SCENARIO_OUTPUT;
        }

        return $this;

    }

    /**
     * @inheritdoc
     */
    public function inOutputScenario()
    {
        return ObjectHelper::SCENARIO_OUTPUT === $this->getScenario();
    }

    /**
     * @inheritdoc
     */
    public function inInputScenario()
    {
        return ObjectHelper::SCENARIO_INPUT === $this->getScenario();
    }

    /**
     * @inheritdoc
     */
    public function toInputScenario()
    {
        $this->setScenario(ObjectHelper::SCENARIO_INPUT);
    }

    /**
     * @inheritdoc
     */
    public function toOutputScenario()
    {
        $this->setScenario(ObjectHelper::SCENARIO_OUTPUT);
    }

    /*****************************************************
     * ERRORS
     *****************************************************/

    /**
     * @inheritdoc
     */
    public function addError($attribute, $error = '')
    {

        // Look for alias
        if ($this->inInputScenario() && $handle = $this->toDynamicHandle($attribute)) {

            $attribute = $handle;

        }

        $this->_traitAddError($attribute, $error);

    }

    /*******************************************
     * MAGIC METHODS
     *******************************************/

    /**
     * @inheritdoc
     */
    public function __call($name, $params)
    {
        throw new UnknownMethodException(sprintf(
                'Calling unknown method: %s::%s() for identity %s',
                (string)get_class($this),
                $name,
                $this->getIdentity()->getHandle()
            )
        );
    }


    /**
     * @inheritdoc
     */
    public function __isset($name)
    {

        if (parent::__isset($name)) {
            return true;
        }

        return $this->isDynamicHandle($name);

    }

    /**
     * @inheritdoc
     */
    public function __get($name)
    {
        $getter = 'get' . $name;
        if (method_exists($this, $getter)) {
            // read property, e.g. getName()
            return $this->$getter();
        } else {
            if ($this->isDynamicHandle($name)) {
                return $this->_prepareDynamicOutputProperty($name);
            }
        }
        if (method_exists($this, 'set' . $name)) {
            throw new InvalidCallException(
                'Getting write-only property: ' . get_class($this) . '::' . $name);
        } else {
            throw new UnknownPropertyException(
                'Getting unknown property: ' . get_class($this) . '::' . $name);
        }
    }

    /**
     * @inheritdoc
     */
    public function __set($name, $value)
    {
        $setter = 'set' . $name;
        if (method_exists($this, $setter)) {
            // set property
            $this->$setter($value);

            return;
        } else {
            if ($this->hasDynamicHandle($name)) {
                $this->_raw[$this->toDynamicHandle($name)] = $value;
                return;
            }
        }
        if (method_exists($this, 'get' . $name)) {
            throw new InvalidCallException('Setting read-only property: ' . get_class($this) . '::' . $name);
        } else {
            throw new UnknownPropertyException('Setting unknown property: ' . get_class($this) . '::' . $name);
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->getIdentity();
    }

}
