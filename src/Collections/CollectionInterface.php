<?php

/**
 * Collection Interface
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

use Flipbox\Skeleton\Error\ErrorInterface;

interface CollectionInterface extends \IteratorAggregate, ErrorInterface
{

    /**
     * Add an item to the current data items
     * @param $item
     */
    public function addItem($item);

    /**
     * @return array|\ArrayIterator
     */
    public function getItems();

    /**
     * @return \ArrayIterator
     */
    public function getIterator();

    /**
     * @return mixed|null
     */
    public function getFirstItem();

    /**
     * Merge one collection into another
     *
     * @param CollectionInterface $collection
     * @return $this
     */
    public function merge(CollectionInterface $collection);

}