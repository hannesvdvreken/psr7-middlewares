<?php
namespace Psr7Stack;

use Psr7Stack\Contracts\Builder as BuilderContract;
use Psr7Stack\Contracts\Core;

class Builder implements BuilderContract
{
    /**
     * @var array
     */
    private $middlewares = [];

    /**
     * @param Core $kernel
     *
     * @return self
     */
    public function push(Core $kernel)
    {
        $that = clone($this);
        $that->middlewares[] = $kernel;

        return $that;
    }

    /**
     * @param Core $kernel
     *
     * @return self
     */
    public function unshift(Core $kernel)
    {
        $that = clone($this);
        array_unshift($that->middlewares, $kernel);

        return $that;
    }

    /**
     * @return Stack
     */
    public function resolve()
    {
        return Stack::create($this->middlewares);
    }
}
