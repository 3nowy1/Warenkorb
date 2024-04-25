<?php

namespace App\DTO;

class CartDTO
{
    private string $cartId;

    private array $items = [];

    /**
     * @param string $cartId
     */
    public function __construct(string $cartId)
    {
        $this->cartId = $cartId;
    }


    public function getCartId(): string
    {
        return $this->cartId;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function setItems(array $items): void
    {
        $this->items = $items;
    }

    public function toArray(): array
    {
        return [
            'cartId' => $this->cartId,
            'items' => $this->items
        ];
    }
}
