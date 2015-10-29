<?php

namespace Evoluta\DropzoneBundle\Manager;

class AwsUploadPolicy
{
    private $expireAt;
    private $bucket;
    private $acl;
    private $successStatus;


    private $base64Policy;
    private $signature;


    /**
     * @param $acl
     * @param $bucket
     * @param $expireAt
     * @param $successStatus
     */
    public function __construct($bucket, $secret, $acl = "private", $expireAt = "+1 hours", $successStatus = 201)
    {
        $this->acl = $acl;
        $this->bucket = $bucket;
        $this->expireAt = $expireAt;
        $this->successStatus = $successStatus;

        $policy = $this->generatePolicy();
        $this->base64Policy = base64_encode($policy);
        $this->signature = base64_encode(hash_hmac('sha1', $this->base64Policy, $secret, $raw_output = true));
    }

    /**
     * @return string
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * @return string
     */
    public function getBase64Policy()
    {
        return $this->base64Policy;
    }

    private function generatePolicy()
    {
        $jsonPolicy =  json_encode(
            array(
                'expiration' => date('Y-m-d\TG:i:s\Z', strtotime($this->expireAt)),
                'conditions' => array(
                    array(
                        'bucket' => $this->bucket,
                    ),
                    array(
                        'acl' => $this->acl,
                    ),
                    array(
                        'starts-with',
                        '$key',
                        '',
                    ),
                    array(
                        'success_action_status' => (string)$this->successStatus,
                    ),
                ),
            )
        );
//
//        echo  $jsonPolicy;
//
//        $accesskey = 'AKIAJDHYBWBHOSUL63WA';
//        $secret = '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';
//        $bucket = 'leandmsdev';
//        echo $this->successStatus;
//        $jsonPolicy = json_encode(
//            array(
//                'expiration' => date('Y-m-d\TG:i:s\Z', strtotime('+1 hours')),
//                'conditions' => array(
//                    array(
//                        'bucket' => $bucket,
//                    ),
//                    array(
//                        'acl' => 'private',
//                    ),
//                    array(
//                        'starts-with',
//                        '$key',
//                        '',
//                    ),
//                    array(
//                        'success_action_status' => (string) $this->successStatus,
//                    ),
//                ),
//            )
//        );

        return $jsonPolicy;
    }
}
