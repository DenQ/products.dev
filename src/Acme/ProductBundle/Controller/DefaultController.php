<?php

namespace Acme\ProductBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Acme\StoreBundle\Entity\Product;

class DefaultController extends Controller{

    public function indexAction($name) {
        return $this->render('AcmeProductBundle:Default:index.html.twig', array('name' => $name));
    }

    public function listAction() {
        $product = $this->getDoctrine()->getRepository('AcmeStoreBundle:Product')->findAll();
        if (!$product)
            throw $this->createNotFoundException('No products');
        return $this->createResponse($this->toJson($product));
    }

    public function getAction($id) {
        $product = $this->getDoctrine()->getRepository('AcmeStoreBundle:Product')->find($id);
        if (!$product)
            throw $this->createNotFoundException('No product found for id '.$id);
        return $this->createResponse($product->toJson());
    }

    public function createAction() {
        $title = $this->requestKey('title');
        $description = $this->requestKey('description');
        $photo = $this->requestKey('photo');
        if ($title && $description && $photo) {
            $product = new Product();
            $product->setTitle($title);
            $product->setDescription($description);
            $product->setPhoto($photo);
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($product);
            $em->flush();
        } else
            throw $this->createNotFoundException('Wrong params');
        return $this->createResponse(json_encode(array('id'=>$product->getId())), Response::HTTP_CREATED);
    }

    public function editAction($id) {
        $em = $this->getDoctrine()->getEntityManager();
        $product = $em->getRepository('AcmeStoreBundle:Product')->find($id);
        if (!$product)
            throw $this->createNotFoundException('No product found for id ' . $id);
        $title = $this->requestKey('title');
        $description = $this->requestKey('description');
        $photo = $this->requestKey('photo');
        if (!$title && !$description && !$photo)
            throw $this->createNotFoundException('Wrong params');
        if ($title)
            $product->setTitle($title);
        if ($description)
            $product->setDescription($description);
        if ($photo)
            $product->setPhoto($photo);
        $em->flush();
        return new Response(null, Response::HTTP_NO_CONTENT);
    }

    public function removeAction($id) {
        $em = $this->getDoctrine()->getEntityManager();
        $product = $em->getRepository('AcmeStoreBundle:Product')->find($id);
        if (!$product)
            throw $this->createNotFoundException('No product found for id ' . $id);
        $em->remove($product);
        $em->flush();
        return new Response(null, Response::HTTP_NO_CONTENT);
    }

    private function toJson($products) {
        $data = array();
        foreach($products as $item)
            $data[] = $item->toArray();
        return json_encode($data);
    }

    private function requestKey($key) {
        return $this->get('request')->request->get($key);
    }

    private function createResponse($msg, $code = Response::HTTP_OK) {
        $response = new Response( $msg, $code);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
