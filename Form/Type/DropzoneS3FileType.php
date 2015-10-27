<?php

namespace Evoluta\DropzoneBundle\Form\Type;

use Aws\AwsClient;
use Evoluta\DropzoneBundle\Manager\AwsUploadPolicy;
use Evoluta\DropzoneBundle\Manager\S3BrowserUploadManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DropzoneS3FileType extends AbstractType
{

    private $configurations;

    public function __construct($accessKey, $secret, $bucket)
    {
        $this->configurations = array(
            'accessKey' => $accessKey,
            'acl' => 'private',
            'successStatus' => 201,
            'policy' => null,
            'signature' => null,
            'bucket' => $bucket,
            'secret' => $secret,
            'expireAt' => date('Y-m-d\TG:i:s\Z', strtotime('+1 hours'))
        );
    }

    public function getName()
    {
        return "dropzoneS3File";
    }

    public function getParent()
    {
        return "url";
    }

    public function configureOptions(OptionsResolver $optionsResolver)
    {
        $optionsResolver->setDefaults(
            $this->configurations
        );
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $bucket = $this->getCorrectOption('bucket', $this->configurations, $options);
        $secret = $this->getCorrectOption('secret', $this->configurations, $options);
        $expireAt = $this->getCorrectOption('expireAt', $this->configurations, $options);
        $acl = $this->getCorrectOption('acl', $this->configurations, $options);
        $successStatus = $this->getCorrectOption('successStatus', $this->configurations, $options);

        $policyObject = new AwsUploadPolicy($bucket, $secret, $acl, $expireAt, $successStatus);

        $view->vars['accessKey'] = $this->getCorrectOption('accessKey', $this->configurations, $options);
        $view->vars['acl'] = $acl;
        $view->vars['successStatus'] = $successStatus;
        $view->vars['policy'] = $policyObject->getBase64Policy();
        $view->vars['signature'] = $policyObject->getSignature();

    }

    private function getCorrectOption($key, $defaultOptions, $forcedOptions)
    {
        if (array_key_exists($key, $forcedOptions)) {
            return $forcedOptions[$key];
        }

        if (array_key_exists($key, $defaultOptions)) {
            return $defaultOptions[$key];
        }

        throw new \Exception('No required '.$key.' option is defined!');
    }
}
