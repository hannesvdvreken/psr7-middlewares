<?php
namespace Psr7Stack\Traits;

use Psr7Stack\Contracts\Core;

trait NextCore
{
    /**
     * @var Core
     */
    protected $next;

    /**
     * @param Core $next
     *
     * @return $this
     */
    public function setNextCore(Core $next)
    {
        $this->next = $next;

        return $this;
    }
}
