<?php

namespace Evoluta\DropzoneBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DropzoneS3FileType extends AbstractType
{

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
                'file_path' => null
            )
        );
    }
}
