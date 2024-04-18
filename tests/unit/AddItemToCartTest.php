<?php

namespace App\Tests\unit;

use App\Repository\ShoppingCartRepository;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class AddItemToCartTest extends TestCase
{
    protected function setUp(): void
    {

    }
    public function testCreateShoppingCartByAddingItem()
    {
        $response = $this->createShoppingCart();

        $this->assertArrayHasKey('cartId', json_decode($response->getBody(), true));
    }

    public function testAddItemToExistingShoppingCart()
    {
        $firstResponse = $this->createShoppingCart();
        $firstCardId = json_decode($firstResponse->getBody(), true)['cartId'];
        $secondResponse = $this->addItemToCart($firstCardId);
        $secondCardId = json_decode($firstResponse->getBody(), true)['cartId'];

        $this->assertArrayHasKey('cartId', json_decode($firstResponse->getBody(), true));
        $this->assertArrayHasKey('cartId', json_decode($secondResponse->getBody(), true));

        $this->assertEquals($firstCardId, $secondCardId);
    }

    private function createShoppingCart()
    {
        $client = new Client(['base_uri' => 'http://localhost:8000']);
        $response = $client->post('/create/cart',
            [
                'body' => json_encode(
                    [
                        'productId' => '123',
                        'quantity' => 1
                    ]
                )
            ]
        );

        return $response;
    }

    private function addItemToCart($cartId)
    {
        $client = new Client(['base_uri' => 'http://localhost:8000']);
        $response = $client->post('/add/cart/item/'.$cartId,
            [
                'body' => json_encode(
                    [
                        'productId' => '124',
                        'quantity' => 1
                    ]
                )
            ]
        );

        return $response;
    }
}
