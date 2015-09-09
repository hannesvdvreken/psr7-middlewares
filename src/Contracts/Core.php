<?php
namespace Psr7Stack\Contracts;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface Core
{
    /**
     * @param RequestInterface $request
     *
     * @return ResponseInterface
     */
    public function handle(RequestInterface $request);
}
