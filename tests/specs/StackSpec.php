<?php
namespace Psr7Stack;

use PhpSpec\ObjectBehavior;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr7Stack\Contracts\Core;
use Psr7Stack\Contracts\Kernel;

class StackSpec extends ObjectBehavior
{
    public function it_is_initializable(Core $core)
    {
        $middlewares = [$core];
        $this->beConstructedThrough('create', [$middlewares]);
        $this->shouldHaveType('Psr7Stack\Stack');
    }

    public function it_returns_response_from_chain_of_cores(
        Core $core,
        RequestInterface $request,
        ResponseInterface $response
    ) {
        $middlewares = [$core];
        $this->beConstructedThrough('create', [$middlewares]);

        $core->handle($request)->willReturn($response);

        $this->handle($request)->shouldReturn($response);
    }

    public function it_set_next_core_until_not_a_kernel(
        Kernel $kernel1,
        Kernel $kernel2,
        Core $core,
        RequestInterface $request,
        ResponseInterface $response
    ) {
        $middlewares = [$kernel1, $kernel2, $core];
        $this->beConstructedThrough('create', [$middlewares]);

        $kernel1->setNextCore($kernel2)->shouldBeCalled()->willReturn($kernel1);
        $kernel2->setNextCore($core)->shouldBeCalled()->willReturn($kernel2);

        $kernel1->handle($request)->willReturn($response);

        $this->handle($request);
    }

    public function it_sets_cores_on_chain_of_kernels_on_all_kernels(
        Kernel $kernel1,
        Kernel $kernel2,
        Core $core,
        Kernel $kernel3,
        RequestInterface $request,
        ResponseInterface $response
    ) {
        $middlewares = [$kernel1, $kernel2, $core, $kernel3];
        $this->beConstructedThrough('create', [$middlewares]);

        $kernel1->setNextCore($kernel2)->shouldBeCalled()->willReturn($kernel1);
        $kernel2->setNextCore($core)->shouldBeCalled()->willReturn($kernel2);

        $kernel1->handle($request)->willReturn($response);

        $this->handle($request);
    }
}
