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


class UpdateProductTest extends WebTestCase
{
    public function testCreate()
    {
        $url = 'product/1/';
        $result = CurlHelper::Send($url, 'PUT', array(
            'title'=>'title',
            'description'=>'description',
            'photo'=>'photo'
        ));
        $this->assertEquals(200, CurlHelper::GetHttpCode());
    }
}