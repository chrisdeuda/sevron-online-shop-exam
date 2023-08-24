<?php

namespace App\DTO;

class OrderDTO
{
    public int $userId;

    public float $totalAmount;

    public string $orderStatus;

    public function __construct(int $userId, float $totalAmount, string $orderStatus)
    {
        $this->userId = $userId;
        $this->totalAmount = $totalAmount;
        $this->orderStatus = $orderStatus;
    }
}
