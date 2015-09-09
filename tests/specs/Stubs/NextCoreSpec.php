<?php
namespace Psr7Stack\Stubs;

use PhpSpec\ObjectBehavior;
use Psr7Stack\Contracts\Core;

class NextCoreSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Psr7Stack\Stubs\NextCore');
    }

    public function it_can_have_a_core_set(Core $core)
    {
        $this->setNextCore($core)->shouldReturn($this);
    }
}
