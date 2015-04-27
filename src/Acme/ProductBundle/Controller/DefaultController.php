<?php

namespace Acme\ProductBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Route;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AcmeProductBundle:Default:index.html.twig', array('name' => $name));
    }

    public function listAction()
    {
        die('product_list');
    }

    public function getAction($id)
    {
        die('product_get id:' . $id);
    }

    public function createAction()
    {
        die('product_create');
    }

    public function editAction($id)
    {
        die('product_edit');
    }

    public function removeAction($id)
    {
        die('product_remove');
    }
}
