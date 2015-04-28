<?php

namespace Acme\ProductBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Acme\StoreBundle\Entity\Product;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AcmeProductBundle:Default:index.html.twig', array('name' => $name));
    }

    public function listAction()
    {
        $response = new Response(json_encode(array('message' => 'product_list')), Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
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
