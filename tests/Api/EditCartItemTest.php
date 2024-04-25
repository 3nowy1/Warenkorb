<?php

namespace App\Tests\Api;

use App\Entity\ShoppingCart;
use App\Repository\ShoppingCartRepository;
use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EditCartItemTest extends WebTestCase
{
    private ShoppingCart $shoppingCart;

    protected function setUp(): void
    {
        $shoppingCart = new ShoppingCart();
        $shoppingCart->setItems([['productId' => 'testProductId', 'quantity' => '1']]);
        $shoppingCartRepository = static::getContainer()->get(ShoppingCartRepository::class);
        $this->shoppingCart = $shoppingCartRepository->saveShoppingCart($shoppingCart);
    }

    protected function tearDown(): void
    {
        $shoppingCartRepository = static::getContainer()->get(ShoppingCartRepository::class);
        $shoppingCartRepository->removeShoppingCart($this->shoppingCart);
    }

    public function testEditItemInShoppingCart()
    {
        $client = new Client(['base_uri' => 'http://localhost:8000']);
        $response = $client->patch(sprintf('/api/carts/%s/products/testProductId', $this->shoppingCart->getId()),
            [
                'json' => [
                        'quantity' => '3'
                ]
            ]
        );

        $this->assertNotEmpty(json_decode($response->getBody(), true)['shoppingCart']);
        $savedCart = json_decode($response->getBody(), true)['shoppingCart'];
        $this->assertNotEmpty($savedCart['cartId']);
        $this->assertEquals($this->shoppingCart->getId(), $savedCart['cartId']);

        foreach($savedCart['items'] as $item) {
            if($item['productId'] === 'test') {
                $this->assertEquals('3', $item['quantity']);
            }
        }
    }
}
