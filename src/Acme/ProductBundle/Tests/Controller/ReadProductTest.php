<?php
/**
 * Created by PhpStorm.
 * User: DenQ
 * Date: 28.04.2015
 * Time: 15:45
 */

namespace Acme\ProductBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Acme\ProductBundle\Helpers\CurlHelper;


class ReadProductTest extends WebTestCase
{
    public function testList()
    {
        $url = 'product/1/';
        $result = CurlHelper::Send($url, 'GET');
//        $this->assertContains('product_get', $result);
        $this->assertEquals(200, CurlHelper::GetHttpCode());
    }
}