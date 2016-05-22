<?php

/**
 * Identity Trait
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

trait IdentityTrait
{

    /**
     * @var IdentityInterface the identity
     */
    protected $_identity;

    /**
     * @return IdentityInterface
     */
    public function getIdentity()
    {
        return $this->_identity;
    }

}
