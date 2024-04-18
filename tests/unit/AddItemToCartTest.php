<?php

namespace App\Tests\unit;

use App\Repository\ShoppingCartRepository;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class AddItemToCartTest extends TestCase
{
    public function testPOST()
    {
            $client = new Client(['base_uri' => 'http://localhost:8000']);
            $response = $client->post('/api/carts',
                ['body' => json_encode(
                    [
                        'productId' => '123',
                        'quantity' => 1
                    ]
                )]
            );

            $this->assertArrayHasKey('cartId', json_decode($response->getBody(), true));
    }
}
