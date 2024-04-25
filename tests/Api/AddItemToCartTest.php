<?php

namespace App\Tests\Api;

use App\Repository\ShoppingCartRepository;
use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AddItemToCartTest extends WebTestCase
{
    private array $deleteIds = [];

    protected function tearDown(): void
    {
        $shoppingCartRepository = static::getContainer()->get(ShoppingCartRepository::class);
        foreach($this->deleteIds as $cartId) {
            $shoppingCart = $shoppingCartRepository->findOneBy(['id' => $cartId]);
            $shoppingCartRepository->removeShoppingCart($shoppingCart);
        }
    }
    public function testCreateShoppingCartByAddingItem()
    {
        $response = $this->createShoppingCart();

        $this->assertArrayHasKey('cartId', json_decode($response->getBody(), true)['shoppingCart']);

        $this->deleteIds[] = [json_decode($response->getBody(), true)['shoppingCart']['cartId']];
    }

    public function testAddItemToExistingShoppingCart()
    {
        $firstResponse = $this->createShoppingCart();
        $firstCart = json_decode($firstResponse->getBody(), true)['shoppingCart'];

        $secondResponse = $this->addItemToCart($firstCart['cartId']);
        $secondCart = json_decode($secondResponse->getBody(), true)['shoppingCart'];

        $this->assertArrayHasKey('cartId', $firstCart);
        $this->assertArrayHasKey('cartId', $secondCart);

        $this->assertEquals($firstCart['cartId'], $secondCart['cartId']);

        $this->deleteIds[] = [$firstCart['cartId'], $secondCart['cartId']];
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
