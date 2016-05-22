<?php

/**
 * Identity Interface
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

use Flipbox\Mapper\Object\ObjectInterface;

interface IdentityInterface
{

    /**
     * The unique object handle
     *
     * @return string
     */
    public function getHandle();

    /**
     * The unique object name
     *
     * @return string
     */
    public function getName();

    /**
     * Instantiates and populates a new object instance with the given set of properties.
     *
     * @param array $config
     * @param bool $isOutputScenario
     * @return ObjectInterface
     */
    public function createObject($config = [], $isOutputScenario = true);

    /**
     * Instantiates and populates a new identity instance with the given set of properties.
     *
     * @param array $config
     * @return IdentityInterface
     */
    public static function create($config = []);

    /**
     * Get the fully qualified name of this class.
     *
     * @return string
     */
    public static function className();

}
