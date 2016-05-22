<?php

/**
 * Collection
 *
 * @package    Mapper
 * @author     Flipbox Factory <hello@flipboxfactory.com>
 * @copyright  2010-2016 Flipbox Digital Limited
 * @license    https://github.com/FlipboxFactory/Mapper/blob/master/LICENSE
 * @version    Release: 1.0.2
 * @link       https://github.com/FlipboxFactory/Mapper
 * @since      Class available since Release 1.0.0
 */

namespace Flipbox\Mapper\Collections;

use Flipbox\Mapper\Object\ObjectInterface;
use Flipbox\Skeleton\Collections\AbstractModelCollection;

class Collection extends AbstractModelCollection
{

    /**
     * The item instance class
     */
    const ITEM_CLASS_INSTANCE = 'Flipbox\\Mapper\\Object\\ObjectInterface';

    /**
     * Get a unique Id for an object
     *
     * @param $item
     * @return string
     */
    protected function getItemId(ObjectInterface $item)
    {
        return $item->getId();
    }

}