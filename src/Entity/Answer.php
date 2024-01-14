<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GraphQl\Query;
use App\Repository\AnswerRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ApiResource]
#[Entity(repositoryClass: AnswerRepository::class)]
#[Query]
class Answer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ApiProperty(identifier: false)]
    #[ORM\Column]
    private ?int $id = null;

    #[ApiProperty(identifier: true)]
    #[ORM\Column(type: 'uuid', unique: true)]
    private UuidInterface $uuid;

    #[ORM\Column(length: 255)]
    private ?string $answer = null;

    #[ORM\ManyToOne(inversedBy: 'answers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Question $question = null;

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

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): void
    {
        $this->question = $question;
    }
}
