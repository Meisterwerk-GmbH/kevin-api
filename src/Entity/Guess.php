<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GraphQl\Mutation;
use App\Repository\GuessRepository;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource(
    operations: [],
    graphQlOperations: [
        new Mutation(name: 'create')
    ]
)]
#[ORM\Entity(repositoryClass: GuessRepository::class)]
#[ORM\UniqueConstraint(columns: ['guesser', 'question_id'])]
class Guess
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $guesser = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Question $question = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Answer $answer = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGuesser(): ?string
    {
        return $this->guesser;
    }

    public function setGuesser(string $guesser): static
    {
        $this->guesser = $guesser;

        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): static
    {
        $this->question = $question;

        return $this;
    }

    public function getAnswer(): ?Answer
    {
        return $this->answer;
    }

    public function setAnswer(?Answer $answer): static
    {
        $this->answer = $answer;

        return $this;
    }
}
