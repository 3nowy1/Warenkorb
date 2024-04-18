<?php

namespace App\DTO;

class CartItemDTO
{
    public function __construct(private string $productId, private string $quantity){}

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function getQuantity(): string
    {
        return $this->quantity;
    }
}
