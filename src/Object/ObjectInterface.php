<?php

/**
 * Object Interface
 *
 * @package    Mapper
 * @author     Flipbox Factory <hello@flipboxfactory.com>
 * @copyright  2010-2016 Flipbox Digital Limited
 * @license    https://github.com/FlipboxFactory/Mapper/blob/master/LICENSE
 * @version    Release: 1.0.0
 * @link       https://github.com/FlipboxFactory/Mapper
 * @since      Class available since Release 1.0.0
 */

namespace Flipbox\Mapper\Object;

use Flipbox\Skeleton\Error\ErrorInterface;
use Traversable;

interface ObjectInterface extends Traversable, ErrorInterface
{

    /**
     * The Internal ID for the object
     *
     * @return string
     */
    public function getId();

    /**
     * Set the Internal ID for the object
     *
     * @param $id
     * @return mixed
     */
    public function setId($id);

    /**
     * Get the object identity object
     *
     * @return \Flipbox\Mapper\Identity\IdentityInterface
     */
    public function getIdentity();

    /**
     * An array of attribute name => alias definitions
     *
     * @param array $attributes
     * @return mixed
     */
    public function getAliasDefinition(array $attributes = []);

    /**
     * Validate the model
     *
     * @param null $attributeNames
     * @param bool $clearErrors
     * @return mixed
     */
    public function validate($attributeNames = null, $clearErrors = true);

    /**
     * Get an array of attribute name => values
     *
     * @param array $attributes
     * @return array
     */
    public function getOutputValues(array $attributes = []);

    /**
     * Get an array of attribute name => values
     *
     * @param array $attributes
     * @return array
     */
    public function getInputValues(array $attributes = []);

    /**
     * Identify if the object is currently in the 'input' scenario
     *
     * @return bool
     */
    public function inInputScenario();

    /**
     * Identify if the object is currently in the 'output' scenario
     *
     * @return bool
     */
    public function inOutputScenario();

    /**
     * Switch to the 'input' scenario
     *
     * @return self
     */
    public function toInputScenario();

    /**
     * Switch to the 'output' scenario
     *
     * @return self
     */
    public function toOutputScenario();

    /**
     * Instantiates and populates a new object instance with the given set of properties.
     *
     * @param mixed $config Properties to populate the object (name => value).
     *
     * @return ObjectInterface The object
     */
    public static function create($config = []);

    /**
     * Populates a new object instance with the given set of properties.
     *
     * @param mixed $config Properties to populate the object with (name => value).
     *
     * @return ObjectInterface The object
     */
    public function populate($config = []);

    /**
     * Get the fully qualified name of this class.
     *
     * @return string
     */
    public static function className();

}