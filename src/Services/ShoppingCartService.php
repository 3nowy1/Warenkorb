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
        $savedCart = $this->shoppingCartRepository->saveShoppingCart($shoppingCart);

        return new CartDTO($savedCart->getId());
    }

    public function addItemToShoppingCart(CartDTO $cartDTO, CartItemDTO $cartItemDTO): CartDTO
    {
        $shoppingCart = $this->shoppingCartRepository->findOneBy(['id' => $cartDTO->getCartId()]);
        $shoppingCart->setItems([['product_id' => $cartItemDTO->getProductId(), 'quantity' => $cartItemDTO->getQuantity()]]);
        $savedCart = $this->shoppingCartRepository->saveShoppingCart($shoppingCart);

        return new CartDTO($savedCart->getId());
    }
}
