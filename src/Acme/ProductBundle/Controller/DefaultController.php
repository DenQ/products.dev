<?php

namespace Acme\ProductBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Acme\StoreBundle\Entity\Product;

class DefaultController extends Controller{

    /**
     * @return Response
     */
    public function indexAction() {
        return $this->render('AcmeProductBundle:Default:index.html.twig');
    }

    /**
     * @return Response
     */
    public function listAction() {
        $product = $this->getDoctrine()->getRepository('AcmeStoreBundle:Product')->findAll();
        if (!$product)
            throw $this->createNotFoundException('No products');
        return $this->createResponse($this->toJson($product));
    }

    /**
     * @param $id
     * @return Response
     */
    public function getAction($id) {
        $product = $this->getDoctrine()->getRepository('AcmeStoreBundle:Product')->find($id);
        if (!$product)
            throw $this->createNotFoundException('No product found for id '.$id);
        return $this->createResponse($product->toJson());
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function createAction(Request $request) {
        $product = new Product();
        $this->settingProduct($product, $request);
        $errors = $this->validateProduct($product);

        if (count($errors) > 0) {
            return $this->createResponse(json_encode($errors), Response::HTTP_BAD_REQUEST);
        } else {
            return $this->saveProduct($product, 'POST');
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function editAction(Request $request, $id) {
        $em = $this->getDoctrine()->getEntityManager();
        $product = $em->getRepository('AcmeStoreBundle:Product')->find($id);
        if (!$product)
            throw $this->createNotFoundException('No product found for id ' . $id);
        $this->settingProduct($product, $request);
        $errors = $this->validateProduct($product);

        if (count($errors) > 0) {
            return $this->createResponse(json_encode($errors), Response::HTTP_BAD_REQUEST);
        }
        return $this->saveProduct($product, 'PUT');
    }

    /**
     * @param $id
     * @return Response
     */
    public function removeAction($id) {
        $em = $this->getDoctrine()->getEntityManager();
        $product = $em->getRepository('AcmeStoreBundle:Product')->find($id);
        if (!$product)
            throw $this->createNotFoundException('No product found for id ' . $id);
        try {
            $em->remove($product);
            $em->flush();
        } catch (\Exception $error) {
            return $this->createResponse(json_encode([
                'msg' => $error->getMessage()
            ]), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return new Response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @param $product Product
     * @return mixed
     */
    private function validateProduct($product) {
        $validator = $this->get('validator');
        return $validator->validate($product);
    }

    /**
     * @param $product Product
     * @param $request Request
     */
    private function settingProduct(& $product, $request) {
        $product->setTitle( $request->get('title') );
        $product->setDescription( $request->get('description') );
        $product->setPhoto( $request->get('photo') );
    }

    /**
     * @param $product Product
     * @param string $scenario
     * @return Response
     */
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

    /**
     * @param $products Product
     * @return string
     */
    private function toJson($products) {
        $data = array();
        foreach($products as $item)
            $data[] = $item->toArray();
        return json_encode($data);
    }

    /**
     * @param $msg
     * @param int $code
     * @return Response
     */
    private function createResponse($msg, $code = Response::HTTP_OK) {
        $response = new Response( $msg, $code);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
