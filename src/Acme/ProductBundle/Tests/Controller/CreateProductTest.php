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


class CreateProductTest extends WebTestCase
{
    public function testCreate()
    {
        $url = 'product/';
        $result = CurlHelper::Send($url, 'POST', array(
            'title'=>'title',
            'description'=>'description',
            'photo'=>'photo'
        ));
        $this->assertContains('id', $result);
        $this->assertEquals(201, CurlHelper::GetHttpCode());
    }
}