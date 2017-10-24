<?php

namespace Evoluta\DropzoneBundle\Form\Type;

use Aws\AwsClient;
use Evoluta\DropzoneBundle\Manager\AwsUploadPolicy;
use Evoluta\DropzoneBundle\Manager\S3BrowserUploadManagerInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Valid;


class DropzoneS3FileType extends AbstractType
{

    private $configurations;

    public function __construct($endpoint, $accessKey, $secret, $bucket)
    {
        $this->configurations = array(
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
            'expireAt' => date('Y-m-d\TG:i:s\Z', strtotime('+1 hours')),
            'constraints' => new Valid()
        );
    }

    public function getBlockPrefix()
    {
        return "dropzoneS3File";
    }

    public function getParent()
    {
        return HiddenType::class;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            $this->configurations
        );
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $endpoint = $this->getCorrectOption('endpoint', $this->configurations, $options);
        $accessKey = $this->getCorrectOption('accessKey', $this->configurations, $options);
        $bucket = $this->getCorrectOption('bucket', $this->configurations, $options);
        $expireAt = $this->getCorrectOption('expireAt', $this->configurations, $options);
        $acl = $this->getCorrectOption('acl', $this->configurations, $options);
        $successStatus = $this->getCorrectOption('successStatus', $this->configurations, $options);
        $secret = $this->getCorrectOption('secret', $this->configurations, $options);
        $acceptedFiles = $this->getCorrectOption('acceptedFiles', $this->configurations, $options);
        $maxFilesize = $this->getCorrectOption('maxFilesize', $this->configurations, $options);
        $directory = $this->getCorrectOption('directory', $this->configurations, $options);

        $policyObject = new AwsUploadPolicy($bucket, $secret, $acl, $expireAt, $successStatus);

        $view->vars = array_merge(
            $view->vars,
            array(
                "endpoint" => $endpoint,
                "accessKey" => $accessKey,
                "bucket" => $bucket,
                "acl" => $acl,
                "successStatus" => $successStatus,
                "policy" => $policyObject->getBase64Policy(),
                "signature" => $policyObject->getSignature(),
                "key" => uniqid().$view->vars['name'],
                "acceptedFiles" => $acceptedFiles,
                "maxFilesize" => $maxFilesize,
                "directory" => $directory
            )
        );

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
