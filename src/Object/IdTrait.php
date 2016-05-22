<?php

/**
 * Id Trait
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

trait IdTrait
{

    /**
     * The Id
     *
     * @var string
     */
    protected $_id;

    /**
     * Get the Id
     *
     * @return string
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Set the Id
     *
     * @param $id
     * @return $this
     */
    public function setId($id)
    {
        $this->_id = $id;
        return $this;
    }

}
