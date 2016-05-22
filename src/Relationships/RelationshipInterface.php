<?php

/**
 * Parent Relationship
 *
 * @package    Mapper
 * @author     Flipbox Factory <hello@flipboxfactory.com>
 * @copyright  2010-2016 Flipbox Digital Limited
 * @license    https://github.com/FlipboxFactory/Mapper/blob/master/LICENSE
 * @version    Release: 1.0.2
 * @link       https://github.com/FlipboxFactory/Mapper
 * @since      Class available since Release 1.0.0
 */

namespace Flipbox\Mapper\Relationships;

use Flipbox\Mapper\Object\ObjectInterface;

interface RelationshipInterface
{

    /**
     * Get a unique Handle
     *
     * @return string
     */
    public function getHandle();

    /**
     * Get a non unique Name
     *
     * @return string
     */
    public function getName();

    /**
     * @param $value
     * @param ObjectInterface $object
     * @return mixed
     */
    public function prepValueForOutput($value, ObjectInterface $object);

    /**
     * @param $value
     * @param ObjectInterface $object
     * @return mixed
     */
    public function prepValueForInput($value, ObjectInterface $object);

}
