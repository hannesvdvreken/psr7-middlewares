<?php
namespace Psr7Stack;

use PhpSpec\ObjectBehavior;
use Psr7Stack\Contracts\Core;

class BuilderSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Psr7Stack\Builder');
    }

    public function it_creates_stack_with_cores(Core $core1, Core $core2)
    {
        $this->push($core1)->unshift($core2)->resolve()->shouldReturnAnInstanceOf('Psr7Stack\Stack');
    }

    public function it_throws_exception_when_stack_empty()
    {
        $this->shouldThrow('Psr7Stack\StackException')->duringResolve();
    }
}
