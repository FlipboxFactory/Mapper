<?php

/**
 * Validation Middleware
 *
 * @package    Mapper
 * @author     Flipbox Factory <hello@flipboxfactory.com>
 * @copyright  2010-2016 Flipbox Digital Limited
 * @license    https://github.com/FlipboxFactory/Mapper/blob/master/LICENSE
 * @version    Release: 1.0.0
 * @link       https://github.com/FlipboxFactory/Mapper
 * @since      Class available since Release 1.0.0
 */

namespace Flipbox\Mapper\Middleware;

use Flipbox\Http\Stream\IteratorStream;
use Flipbox\Mapper\Exceptions\InvalidObjectException;
use Flipbox\Mapper\Object\ObjectInterface;
use Flipbox\Relay\Middleware\AbstractMiddleware;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Validate extends AbstractMiddleware
{

    /**
     * @var ObjectInterface the object
     */
    public $object;

    /**
     * @var array the attributes to validate
     */
    public $attributes;

    /**
     * @throws InvalidObjectException
     */
    public function init()
    {

        if (!$this->object instanceof ObjectInterface) {

            throw new InvalidObjectException(
                sprintf(
                    "The class '%s' requires an object that is an instance of '%s'",
                    get_class($this),
                    'Flipbox\Mapper\Object\ObjectInterface'
                )
            );

        }

    }

    /**
     * @inheritdoc
     */
    public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next = null)
    {

        // Validate object
        if (!$this->object->validate($this->attributes)) {

            return $response->withBody(
                new IteratorStream($this->object)
            );

        }

        // Onward
        return $next($request, $response);

    }

}