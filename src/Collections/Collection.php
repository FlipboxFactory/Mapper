<?php

/**
 * Collection
 *
 * @package    Mapper
 * @author     Flipbox Factory <hello@flipboxfactory.com>
 * @copyright  2010-2016 Flipbox Digital Limited
 * @license    https://github.com/FlipboxFactory/Mapper/blob/master/LICENSE
 * @version    Release: 1.0.0
 * @link       https://github.com/FlipboxFactory/Mapper
 * @since      Class available since Release 1.0.0
 */

namespace Flipbox\Mapper\Collections;

use Flipbox\Mapper\Exceptions\InvalidItemException;
use Flipbox\Mapper\Object\ObjectInterface;
use Flipbox\Skeleton\Error\ErrorTrait;
use Flipbox\Skeleton\Helpers\ArrayHelper;
use Flipbox\Skeleton\Object\AbstractObject;

class Collection extends AbstractObject implements CollectionInterface
{

    use ErrorTrait {
        getErrors as _traitGetErrors;
        clearErrors as _traitClearErrors;
    }

    /**
     * The item instance class
     */
    const ITEM_CLASS_INSTANCE = 'Flipbox\\Mapper\\Object\\ObjectInterface';

    /**
     * A collection of items.
     *
     * @var array|\ArrayIterator
     */
    protected $_items = [];


    /*******************************************
     * ITEMS
     *******************************************/

    /**
     * Add an item to a collection
     *
     * @param $item
     * @return $this
     * @throws InvalidItemException
     */
    public function addItem($item)
    {

        // Item class instance
        $itemInstance = static::ITEM_CLASS_INSTANCE;

        // Validate instance
        if ($itemInstance && !$item instanceof $itemInstance) {

            throw new InvalidItemException(
                sprintf(
                    "Unable to add item to collection because it must be an instance of '%s'",
                    static::ITEM_CLASS_INSTANCE
                )
            );

        }

        $this->_items[] = $item;

        return $this;

    }

    /**
     * @param array $items
     * @return $this
     */
    public function setItems($items = [])
    {
        $this->_items = [];

        // Make sure we can iterate over it
        if (!is_array($items) && !$items instanceof \Traversable) {
            $items = [$items];
        }

        foreach ($items as $item) {
            $this->addItem($item);
        }

        return $this;
    }

    /**
     * @return array|\ArrayIterator
     */
    public function getItems()
    {
        return $this->_items;
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {

        $items = $this->getItems();

        if ($items instanceof \ArrayIterator) {

            return $items;

        }

        return new \ArrayIterator($items);

    }

    /**
     * @return mixed|null
     */
    public function getFirstItem()
    {

        if ($items = $this->getItems()) {
            return ArrayHelper::getFirstValue($items);
        }

        return null;

    }


    /*******************************************
     * MERGE
     *******************************************/

    /**
     * Merge one collection into another
     *
     * @param CollectionInterface $collection
     * @return $this
     */
    public function merge(CollectionInterface $collection)
    {

        $this->_items = array_merge(
            $this->getItems(),
            $collection->getItems()
        );

        return $this;

    }


    /*******************************************
     * AGGREGATE ERRORS
     *******************************************/

    /**
     * Merge errors from all
     * @inheritdoc
     */
    public function getErrors($attribute = null)
    {

        $itemErrors = [];

        /** @var ObjectInterface $item */
        foreach ($this->getItems() as $item) {

            if ($item->hasErrors($attribute)) {

                $itemErrors[$item->getIdentity()->getHandle()][$item->getId()] = $item->getErrors($attribute);

            }

        }

        return array_merge(
            $this->_traitGetErrors($attribute),
            $itemErrors
        );

    }

    /**
     * @inheritdoc
     */
    public function clearErrors($attribute = null)
    {

        /** @var ObjectInterface $item */
        foreach ($this->getItems() as $item) {
            $item->clearErrors($attribute);
        }

        $this->_traitClearErrors($attribute);

    }

}