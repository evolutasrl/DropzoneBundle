<?php

namespace Evoluta\DropzoneBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DropzoneFileField extends AbstractType
{

    public function getName()
    {
        return "dropzoneFile";
    }

    public function getParent()
    {
        return "file";
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
