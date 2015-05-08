<?php

namespace Acme\ProductBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Acme\StoreBundle\Entity\Product;

class DefaultController extends Controller{

    public function indexAction() {
        return $this->render('AcmeProductBundle:Default:index.html.twig');
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
        $product = new Product();
        $product->setTitle( $this->requestKey('title') );
        $product->setDescription( $this->requestKey('description') );
        $product->setPhoto( $this->requestKey('photo') );

        $validator = $this->get('validator');
        $errors = $validator->validate($product);
        if (count($errors) > 0) {
            return $this->createResponse(json_encode($errors), Response::HTTP_BAD_REQUEST);
        } else {
            return $this->saveProduct($product, 'POST');
        }
    }

    public function editAction($id) {
        $em = $this->getDoctrine()->getEntityManager();
        $product = $em->getRepository('AcmeStoreBundle:Product')->find($id);
        if (!$product)
            throw $this->createNotFoundException('No product found for id ' . $id);
        $product->setTitle( $this->requestKey('title') );
        $product->setDescription( $this->requestKey('description') );
        $product->setPhoto( $this->requestKey('photo') );

        $validator = $this->get('validator');
        $errors = $validator->validate($product);
        if (count($errors) > 0) {
            return $this->createResponse(json_encode($errors), Response::HTTP_BAD_REQUEST);
        }
        return $this->saveProduct($product, 'PUT');
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


    private function saveProduct($product, $scenario = "POST") {
        try {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($product);
            $em->flush();
            $ResponseData = null;
            $ResponseCode = Response::HTTP_NO_CONTENT;
            if ($scenario === "POST") {
                $ResponseData = json_encode(array('id'=>$product->getId()));
                $ResponseCode = Response::HTTP_CREATED;
            } return $this->createResponse($ResponseData, $ResponseCode);
        } catch(\Exception $error) {
            return $this->createResponse(json_encode([
                'msg' => $error->getMessage()
            ]), Response::HTTP_INTERNAL_SERVER_ERROR);
        };
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
