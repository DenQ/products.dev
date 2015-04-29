<?php

namespace Acme\ProductBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Acme\ProductBundle\Helpers\CurlHelper;

class HttpResponseApiTest extends WebTestCase
{
    public function testList()
    {
        $url = 'products/';
        $result = CurlHelper::Send($url, 'GET');
//        $this->assertContains('product_list', $result);
        $this->assertEquals(200, CurlHelper::GetHttpCode());
    }

    public function testGet()
    {
        $url = 'product/1/';
        $result = CurlHelper::Send($url, 'GET');
//        $this->assertContains('product_get', $result);
        $this->assertEquals(200, CurlHelper::GetHttpCode());
    }

    public function testCreate()
    {
//        $url = 'product/';
//        $result = CurlHelper::Send($url, 'POST');
////        $this->assertContains('product_create', $result);
//        $this->assertEquals(200, CurlHelper::GetHttpCode());
        $url = 'product/';
        $result = CurlHelper::Send($url, 'POST', array(
            'title'=>'title',
            'description'=>'description',
            'photo'=>'photo'
        ));
//        $this->assertContains('product_create', $result);
        $this->assertEquals(200, CurlHelper::GetHttpCode());
    }

    public function testEdit()
    {
        $url = 'product/1/';
        $result = CurlHelper::Send($url, 'PUT');
//        $this->assertContains('product_edit', $result);
        $this->assertEquals(200, CurlHelper::GetHttpCode());
    }

    public function testRemove()
    {
        $url = 'product/1/';
        $result = CurlHelper::Send($url, 'DELETE');
//        $this->assertContains('product_remove', $result);
        $this->assertEquals(200, CurlHelper::GetHttpCode());
    }
}