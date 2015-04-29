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


class DeleteProductTest extends WebTestCase
{
    public function testCreate()
    {
        $url = 'product/2/';
        $result = CurlHelper::Send($url, 'DELETE');
        $this->assertEquals(200, CurlHelper::GetHttpCode());
    }
}