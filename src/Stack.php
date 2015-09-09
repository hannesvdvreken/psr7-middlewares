<?php
namespace Psr7Stack;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr7Stack\Contracts\Core;
use Psr7Stack\Contracts\Kernel;

class Stack implements Core
{
    /**
     * @var Kernel[]
     */
    private $middlewares;

    /**
     * @param RequestInterface $request
     *
     * @return ResponseInterface
     */
    public function handle(RequestInterface $request)
    {
        $index = 0;

        while ($this->canSetNextCore($index)) {
            $this->middlewares[$index]->setNextCore($this->middlewares[$index + 1]);
            ++$index;
        }

        return $this->middlewares[0]->handle($request);
    }

    /**
     * @param Kernel[] $middlewares
     *
     * @throws StackException
     *
     * @return static
     */
    public static function create(array $middlewares)
    {
        if (empty($middlewares)) {
            throw new StackException('Middlewares array cannot be empty.');
        }

        $stack = new static();

        $stack->middlewares = $middlewares;

        return $stack;
    }

    /**
     * @param int $index
     *
     * @return bool
     */
    private function canSetNextCore($index)
    {
        if (count($this->middlewares) <= $index + 1) {
            // Prevent index out of bounds error
            return false;
        }

        if ($this->middlewares[$index] instanceof Kernel) {
            // As long as the current core is a kernel it can be notified of next core.
            return true;
        }

        return false;
    }
}
