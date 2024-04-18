<?php

namespace App\Services;

use App\DTO\CartDTO;
use App\DTO\CartItemDTO;
use App\Entity\ShoppingCart;
use App\Repository\ShoppingCartRepository;

class ShoppingCartService
{

    public function __construct(private ShoppingCartRepository $shoppingCartRepository)
    {
    }

    public function createNewShoppingCart(CartItemDTO $cartItemDTO): CartDTO
    {
        $shoppingCart = new ShoppingCart();
        $shoppingCart->setItems([['product_id' => $cartItemDTO->getProductId(), 'quantity' => $cartItemDTO->getQuantity()]]);
        $savedCart = $this->shoppingCartRepository->saveNewCart($shoppingCart);

        $cartDto = new CartDTO();
        $cartDto->setCartId($savedCart->getId());

        return $cartDto;
    }
}
