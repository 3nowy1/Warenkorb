<?php

namespace App\Tests\Api;

use App\Entity\ShoppingCart;
use App\Repository\ShoppingCartRepository;
use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ShowCartTest extends WebTestCase
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

    public function testShowShoppingCart()
    {
        $client = new Client(['base_uri' => 'http://localhost:8000']);
        $response = $client->get(sprintf('/api/carts/%s', $this->shoppingCart->getId()));

        $this->assertNotEmpty(json_decode($response->getBody(), true)['shoppingCart']);
        $shoppingCart = json_decode($response->getBody(), true)['shoppingCart'];
        $this->assertNotEmpty($shoppingCart['cartId']);
        $this->assertEquals($this->shoppingCart->getId(), $shoppingCart['cartId']);
        $this->assertJsonStringEqualsJsonString(
            sprintf(
                '{"shoppingCart":{"cartId":"%s","items":[{"productId":"testProductId","quantity":"1"},{"productId":"secondTestProductId","quantity":"2"}]}}',
                $shoppingCart['cartId']),
            $response->getBody()
        );
    }
}
