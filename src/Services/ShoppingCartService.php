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
        $shoppingCart->setItems([['productId' => $cartItemDTO->getProductId(), 'quantity' => $cartItemDTO->getQuantity()]]);
        $savedCart = $this->shoppingCartRepository->saveShoppingCart($shoppingCart);

        return new CartDTO($savedCart->getId());
    }

    public function addItemToShoppingCart(CartDTO $cartDTO, CartItemDTO $cartItemDTO): CartDTO
    {
        $shoppingCart = $this->shoppingCartRepository->findOneBy(['id' => $cartDTO->getCartId()]);
        $shoppingCart->setItems([['productId' => $cartItemDTO->getProductId(), 'quantity' => $cartItemDTO->getQuantity()]]);
        $savedCart = $this->shoppingCartRepository->saveShoppingCart($shoppingCart);

        return new CartDTO($savedCart->getId());
    }

    public function editShoppingCartItem(string $cartId, CartItemDTO $cartItemDTO): CartDTO
    {
        $shoppingCart = $this->shoppingCartRepository->findOneBy(['id' => $cartId]);
        $shoppingCart->setItems([['productId' => $cartItemDTO->getProductId(), 'quantity' => $cartItemDTO->getQuantity()]]);
        $savedCart = $this->shoppingCartRepository->saveShoppingCart($shoppingCart);

        return new CartDTO($savedCart->getId());
    }

    public function removeShoppingCartItem(string $cartId, string $productId): CartDTO
    {
        $shoppingCart = $this->shoppingCartRepository->findOneBy(['id' => $cartId]);
        $items = $shoppingCart->getItems();

        foreach ($items as $index => $item) {
            if ($item['productId'] === $productId) {
                unset($items[$index]);
            }
        }

        $shoppingCart->setItems($items);
        $savedCart = $this->shoppingCartRepository->saveShoppingCart($shoppingCart);

        $savedCartDTO = new CartDTO($savedCart->getId());
        $savedCartDTO->setItems($savedCart->getItems());

        return $savedCartDTO;
    }
}
