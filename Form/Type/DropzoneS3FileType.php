<?php

namespace Evoluta\DropzoneBundle\Form\Type;

use Evoluta\DropzoneBundle\Manager\S3BrowserUploadManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DropzoneS3FileType extends AbstractType
{
    private $S3BrowserUploadManager;

    public function __construct(S3BrowserUploadManagerInterface $S3BrowserUploadManager)
    {
        $this->S3BrowserUploadManager = $S3BrowserUploadManager;
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
            array(
                'attr' => array(
                    'AWSAccessKeyId' => '123',
                    'acl' => null,
                    'success_action_status' => null,
                    'policy' => null,
                    'signature' => null
                )
            )
        );
    }


}
