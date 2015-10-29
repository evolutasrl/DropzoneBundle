<?php

namespace spec\Evoluta\DropzoneBundle\Manager;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AwsUploadPolicySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Evoluta\DropzoneBundle\Manager\AwsUploadPolicy');
    }

    public function let()
    {
        $this->beConstructedWith('bucket', 'secret', 'private', '+1 hours', 201);
    }

    public function it_can_generate_policy()
    {
        $json = json_encode(
            array(
                'expiration' => date('Y-m-d\TG:i:s\Z', strtotime('+1 hours')),
                'conditions' => array(
                    array(
                        'bucket' => "bucket",
                    ),
                    array(
                        'acl' => 'private',
                    ),
                    array(
                        'starts-with',
                        '$key',
                        '',
                    ),
                    array(
                        'success_action_status' => "201",
                    ),
                ),
            )
        );

        $base64Policy = base64_encode($json);
        $signature = base64_encode(hash_hmac('sha1', $base64Policy, 'secret', true));


        $this->getSignature()->shouldReturn($signature);
        $this->getBase64Policy()->shouldReturn($base64Policy);
    }

}
