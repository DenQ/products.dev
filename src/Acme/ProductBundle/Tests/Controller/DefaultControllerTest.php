<?php

namespace Acme\ProductBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Acme\ProductBundle\Helpers\CurlHelper;

class DefaultControllerTest extends WebTestCase
{
    public function testList()
    {
        $url = 'products/';
        $result = CurlHelper::Send($url, 'GET');
        $this->assertContains('product_list', $result);
    }

    public function testGet()
    {
        $url = 'product/1/';
        $result = CurlHelper::Send($url, 'GET');
        $this->assertContains('product_get', $result);
    }

    public function testCreate()
    {
        $url = 'product/';
        $result = CurlHelper::Send($url, 'POST');
        echo $result;
        $this->assertContains('product_create', $result);
    }

    public function testEdit()
    {
        $url = 'product/1/';
        $result = CurlHelper::Send($url, 'PUT');
        $this->assertContains('product_edit', $result);
    }

    public function testRemove()
    {
        $url = 'product/1/';
        $result = CurlHelper::Send($url, 'DELETE');
        $this->assertContains('product_remove', $result);
    }
}