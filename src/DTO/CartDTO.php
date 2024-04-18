<?php

namespace App\DTO;

class CartDTO
{
    private string $cartId;

    private array $items;

    public function getCartId(): string
    {
        return $this->cartId;
    }

    public function setCartId(string $cartId): void
    {
        $this->cartId = $cartId;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function setItems(array $items): void
    {
        $this->items = $items;
    }


}
