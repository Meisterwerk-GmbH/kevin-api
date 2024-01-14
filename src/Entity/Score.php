<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GraphQl\Query;
use App\Resolver\ScoreResolver;

#[ApiResource(
    operations: [],
    graphQlOperations: [
        new Query(
            resolver: ScoreResolver::class,
            read: false
        )
    ]
)]
class Score
{
    #[ApiProperty(identifier: true)]
    private string $guesser;

    public function __construct(
        string $guesser,
        private readonly int $score
    ) {
        $this->guesser = $guesser;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function getGuesser(): string
    {
        return $this->guesser;
    }
}