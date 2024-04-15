<?php

namespace App\Tests\unit;

use App\Controller\AddItemToCartController;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Throwable;

class AddItemToCartTest extends TestCase
{
    public function testPOST()
    {
        try {
            $client = new Client(['base_uri' => 'http://localhost:8000']);
            $request = $client->post('/add/item/to/cart', []);
//            $request = $client->request('GET', '/add/item/to/cart');
            $response = $request->send();
        } catch (Throwable $e) {
            $test = $e->getMessage();
            echo "\n ERROR: ".$test."\n";
        }

//        $nickname = 'ObjectOrienter'.rand(0, 999);
//        $data = array(
//            'nickname' => $nickname,
//            'avatarNumber' => 5,
//            'tagLine' => 'a test dev!'
//        );
//
////        $request = $client->request('GET', '/add/item/to/cart');
//        $request = $client->post('/add/item/to/cart', []);
//        $response = $request->send();
//        $this->assertEquals("tut", $response);
    }
}
