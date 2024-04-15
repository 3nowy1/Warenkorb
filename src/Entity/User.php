<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User
{
    #[
        ORM\Id,
        ORM\GeneratedValue(strategy: 'CUSTOM'),
        ORM\CustomIdGenerator(UuidGenerator::class),
        ORM\Column(type: Types::STRING)
    ]
    private int $id;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $forname;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $lastname;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getForname(): string
    {
        return $this->forname;
    }

    public function setForname(string $forname): void
    {
        $this->forname = $forname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }
}
