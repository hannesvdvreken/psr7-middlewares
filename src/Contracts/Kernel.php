<?php
namespace Psr7Stack\Contracts;

interface Kernel extends Core
{
    /**
     * @param Core $next
     *
     * @return $this
     */
    public function setNextCore(Core $next);
}
