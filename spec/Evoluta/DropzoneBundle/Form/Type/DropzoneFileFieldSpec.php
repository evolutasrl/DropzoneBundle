<?php

namespace spec\Evoluta\DropzoneBundle\Form\Type;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DropzoneFileFieldSpec extends ObjectBehavior
{

    public function it_is_initializable()
    {
        $this->shouldHaveType('Evoluta\DropzoneBundle\Form\Type\DropzoneFileField');
    }

    public function it_should_return_name()
    {
        $this->getName()->shouldReturn('dropzoneFile');
    }

    public function it_should_return_parent()
    {
        $this->getParent()->shouldReturn('file');
    }

    public function it_can_configure_option_resolver($resolver)
    {
        $resolver->beADoubleOf('Symfony\Component\OptionsResolver\OptionsResolver');
        $resolver->setDefaults(Argument::any())->shouldBeCalled();
        $this->configureOptions($resolver);
    }
}
