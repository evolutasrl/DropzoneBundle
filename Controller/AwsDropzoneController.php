<?php

namespace Evoluta\DropzoneBundle\Controller;

use Evoluta\DropzoneBundle\Manager\AwsUploadPolicy;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Evoluta\CdsDms\GuardianContextBundle\Annotation\GuardianAnnotation;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AwsDropzoneController extends FOSRestController
{

    private $defaultOptions;

    /**
     * AwsDropzoneController constructor.
     * @param $endpoint
     * @param $accessKey
     * @param $secret
     * @param $bucket
     */
    public function __construct($endpoint, $accessKey, $secret, $bucket)
    {

        $this->defaultOptions = array(
            'endpoint' => $endpoint,
            'accessKey' => $accessKey,
            'acl' => 'public-read',
            'successStatus' => 201,
            'policy' => null,
            'signature' => null,
            'maxFilesize' => 10,
            'directory' => '',
            'bucket' => $bucket,
            'secret' => $secret,
            'acceptedFiles' => null,
            'expireAt' => date('Y-m-d\TG:i:s\Z', strtotime('+1 hours'))
        );

    }


    /**
     * @Route("/uploadData", name="evoluta_dropzone_bundle.get_aws_auth_data")
     * @Method({"GET"})
     * @Rest\View
     */
    public function getAuthDataAction(Request $request)
    {

        $vars = array(
            "endpoint" => $request->get('endpoint', $this->defaultOptions['endpoint']),
            "accessKey" => $request->get('accessKey', $this->defaultOptions['accessKey']),
            "bucket" => $request->get('bucket', $this->defaultOptions['bucket']),
            "acl" => $request->get('acl', $this->defaultOptions['acl']),
            "successStatus" => $request->get('successStatus', $this->defaultOptions['successStatus']),
            "key" => uniqid().$request->get('filename'),
            "secret" =>  $request->get('secret', $this->defaultOptions['secret']),
            "acceptedFiles" => $request->get('acceptedFiles', $this->defaultOptions['acceptedFiles']),
            "maxFilesize" => $request->get('maxFilesize', $this->defaultOptions['maxFilesize']),
            "directory" => $request->get('directory', $this->defaultOptions['directory']),
            'expireAt' => date('Y-m-d\TG:i:s\Z', strtotime('+1 hours'))
        );

        $policyObject = new AwsUploadPolicy($vars['bucket'], $vars['secret'], $vars['acl'], $vars['expireAt'], $vars['successStatus']);

        $vars["policy"] = $policyObject->getBase64Policy();
        $vars["signature"] = $policyObject->getSignature();

        return $vars;

    }


}
