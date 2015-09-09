<?php
namespace Psr7Stack\Contracts;

use Psr7Stack\Stack;

interface Builder
{
    /**
     * @param Core $kernel
     *
     * @return self
     */
    public function push(Core $kernel);

    /**
     * @param Core $kernel
     *
     * @return self
     */
    public function unshift(Core $kernel);

    /**
     * @return Stack
     */
    public function resolve();
}
