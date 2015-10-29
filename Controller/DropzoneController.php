<?php

namespace Evoluta\DropzoneBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class DropzoneController extends FOSRestController
{
    /**
     * @Route("/", name="evoluta_dropzone.test")
     * @Rest\View
     */
    public function testAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add(
                'task1',
                'dropzoneS3File'
            )
            ->add(
                'task2',
                'dropzoneS3File',
                array(
                    'acceptedFiles' => 'image/*',
                    'directory' => 'images/sub1/sub2'
                )
            )
            ->add(
                'task3',
                'dropzoneS3File'
            )
            ->getForm();
        $form->submit(array('task1' => 'preexist'));

        return ['form' => $form];
    }
}
