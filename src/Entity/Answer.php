<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GraphQl\Query;
use App\Repository\AnswerRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\InheritanceType;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ApiResource]
#[Entity(repositoryClass: AnswerRepository::class)]
#[InheritanceType('JOINED')]
#[Query]
class Answer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ApiProperty(identifier: false)]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'uuid', unique: true)]
    private UuidInterface $uuid;

    #[ApiProperty(identifier: true)]
    #[ORM\Column(length: 255)]
    private ?string $answer = null;

    public function __construct(string $answer, UuidInterface $uuid = null)
    {
        $this->answer = $answer;
        $this->uuid = $uuid ?: Uuid::uuid4();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    public function setAnswer(string $answer): static
    {
        $this->answer = $answer;

        return $this;
    }

    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }
}
