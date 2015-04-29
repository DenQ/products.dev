<?php

namespace Acme\ProductBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Acme\StoreBundle\Entity\Product;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AcmeProductBundle:Default:index.html.twig', array('name' => $name));
    }

    public function listAction()
    {
//        $response = new Response(json_encode(array('message' => 'product_list')), Response::HTTP_OK);
//        $response->headers->set('Content-Type', 'application/json');
//        return $response;

        $product = $this->getDoctrine()
            ->getRepository('AcmeStoreBundle:Product')
            ->findAll();

        if (!$product) {
            throw $this->createNotFoundException('No products');
        }
        $data = array();
        foreach($product as $item) {
            $data[] = [
                'id'=>$item->getId(),
                'title'=>$item->getTitle(),
                'description'=>$item->getDescription(),
                'photo'=>$item->getPhoto(),
            ];
        }
        $response = new Response(json_encode($data), Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function getAction($id)
    {
        $product = $this->getDoctrine()
            ->getRepository('AcmeStoreBundle:Product')
            ->find($id);

        if (!$product) {
            throw $this->createNotFoundException('No product found for id '.$id);
        }
        $response = new Response(json_encode(array(
            'id'=>$product->getId(),
            'title'=>$product->getTitle(),
            'description'=>$product->getDescription(),
            'photo'=>$product->getPhoto(),
        ) ), Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function createAction()
    {
        $title = $this->get('request')->request->get('title');
        $description = $this->get('request')->request->get('description');
        $photo = $this->get('request')->request->get('photo');

        $product = new Product();
        $product->setTitle($title);
        $product->setDescription($description);
        $product->setPhoto($photo);

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($product);
        $em->flush();
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
