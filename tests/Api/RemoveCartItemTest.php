<?php

namespace App\Tests\Api;

use App\Entity\ShoppingCart;
use App\Repository\ShoppingCartRepository;
use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RemoveCartItemTest extends WebTestCase
{
    private ShoppingCart $shoppingCart;

    protected function setUp(): void
    {
        $shoppingCart = new ShoppingCart();
        $shoppingCart->setItems([['productId' => 'testProductId', 'quantity' => '1'], ['productId' => 'secondTestProductId', 'quantity' => '2']]);
        $shoppingCartRepository = static::getContainer()->get(ShoppingCartRepository::class);
        $this->shoppingCart = $shoppingCartRepository->saveShoppingCart($shoppingCart);
    }

    protected function tearDown(): void
    {
        $shoppingCartRepository = static::getContainer()->get(ShoppingCartRepository::class);
        $shoppingCartRepository->removeShoppingCart($this->shoppingCart);
    }

    public function testRemoveItemFromShoppingCart()
    {
        $client = new Client(['base_uri' => 'http://localhost:8000']);
        $response = $client->delete(sprintf('/api/carts/%s/products/testProductId', $this->shoppingCart->getId()));

        $this->assertNotEmpty(json_decode($response->getBody(), true)['shoppingCart']);
        $savedCart = json_decode($response->getBody(), true)['shoppingCart'];
        $this->assertNotEmpty($savedCart['cartId']);
        $this->assertEquals($this->shoppingCart->getId(), $savedCart['cartId']);
        $this->assertJsonStringEqualsJsonString(sprintf('{"shoppingCart":{"cartId":"%s","items":{"1":{"productId":"secondTestProductId","quantity":"2"}}}}', $savedCart['cartId']), $response->getBody());
    }
}
