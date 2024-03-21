<?php

namespace Training\Bundle\FrontendTrainingBundle\Provider\DTO;

final class UserStat
{
    public function __construct(
        private readonly string $firstName,
        private readonly string $lastName,
        private readonly string $email,
        private readonly int $ordersCount
    ) {
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getOrdersCount(): int
    {
        return $this->ordersCount;
    }

    public function toArray(): array
    {
        return [
            'firstName' => $this->getFirstName(),
            'lastName' => $this->getLastName(),
            'email' => $this->getEmail(),
            'ordersCount' => $this->getOrdersCount()
        ];
    }
}
