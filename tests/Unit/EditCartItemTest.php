<?php

namespace App\Tests\Unit;

use App\DTO\CartDTO;
use App\Entity\ShoppingCart;
use App\Repository\ShoppingCartRepository;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class EditCartItemTest extends TestCase
{

    private CartDTO $cartDTO;
    private string $productId;

    protected function setUp(): void
    {
        $this->productId = Uuid::uuid4()->toString();
        $employeeRepository = $this->createMock(ShoppingCartRepository::class);
        $shoppingCart = new ShoppingCart();
        $shoppingCart->setItems([['product_id' => $this->productId, 'quantity' => '1']]);
        $savedCart = $employeeRepository->saveShoppingCart($shoppingCart);

        $this->cartDTO = new CartDTO($savedCart->getId());
    }

    public function testEditItemInShoppingCart()
    {
        $client = new Client(['base_uri' => 'http://localhost:8000']);
        $response = $client->patch('/edit/cart/item/'.$this->cartDTO->getCartId(),
            [
                'body' => json_encode(
                    [
                        'productId' => $this->productId,
                        'quantity' => '3'
                    ]
                )
            ]
        );
            var_dump($this->cartDTO->getItems());
//        $this->assertEquals('3', $this->cartDTO->getItems()[$this->productId]->getQuantity());
    }
}
