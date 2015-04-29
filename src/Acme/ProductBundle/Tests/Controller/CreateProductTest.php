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


class CreateProductTest  extends WebTestCase
{
    public function testCreate()
    {
        $url = 'product/';
        $result = CurlHelper::Send($url, 'POST', array(
            'title'=>'title',
            'description'=>'description',
            'photo'=>'photo'
        ));
//        $this->assertContains('product_create', $result);
        $this->assertEquals(200, CurlHelper::GetHttpCode());
    }
}