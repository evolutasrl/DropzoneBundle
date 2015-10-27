<?php

namespace spec\Evoluta\DropzoneBundle\Manager;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class S3BrowserUploadManagerSpec extends ObjectBehavior
{

    public function let()
    {
        $this->beConstructedWith();
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Evoluta\DropzoneBundle\Manager\S3BrowserUploadManager');
    }
}
