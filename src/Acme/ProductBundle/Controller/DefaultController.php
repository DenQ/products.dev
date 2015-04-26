<?php

namespace Acme\ProductBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AcmeProductBundle:Default:index.html.twig', array('name' => $name));
    }

    public function listAction()
    {
        die('list');
    }

    public function getAction($id)
    {
        die('get id:' . $id);
    }

    public function createAction()
    {
        die('create');
    }
}
