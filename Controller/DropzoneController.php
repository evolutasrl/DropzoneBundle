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
            ->add('task', 'dropzoneS3File', array('attr'=>array('AWSAccessKeyId' => "ddsfasdfasd")))
            ->getForm();

        return ['form' => $form];
    }
}
