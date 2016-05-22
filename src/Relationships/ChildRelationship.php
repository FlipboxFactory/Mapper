<?php

/**
 * Child Relationship
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

use Flipbox\Mapper\Collections\Collection;
use Flipbox\Mapper\Collections\CollectionInterface;
use Flipbox\Mapper\Object\ObjectInterface;
use Flipbox\Skeleton\Helpers\ArrayHelper;

class ChildRelationship extends AbstractRelationship
{

    /**
     * @param $value
     * @param ObjectInterface $object
     * @return mixed
     */
    public function prepValueForOutput($value, ObjectInterface $object)
    {
        return $this->createCollection(
            ArrayHelper::getValue($value, 'records', $value)
        );
    }

    /**
     * @param $value
     * @param ObjectInterface $object
     * @return mixed
     */
    public function prepValueForInput($value, ObjectInterface $object)
    {
        return $this->createCollection(
            ArrayHelper::getValue($value, 'records', $value)
        );
    }

    /**
     * Create a new collection and populate it with child objects
     *
     * @param array $records
     * @return CollectionInterface
     */
    protected function createCollection($records = [])
    {

        /** @var CollectionInterface $collection */
        $collection = Collection::create();

        if (!empty($records)) {

            foreach ($records as $record) {

                $collection->addItem(
                    $this->_object->createObject($record)
                );

            }

        }

        return $collection;

    }

}
