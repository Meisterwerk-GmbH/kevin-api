<?php

namespace App\ApiResource;

use Ramsey\Uuid\UuidInterface;

class AnswerDto
{
    public function __construct(
        protected UuidInterface $uuid,
        protected string $answer
    ) {}

    public function getAnswer(): string
    {
        return $this->answer;
    }

    public function setAnswer(string $answer): void
    {
        $this->answer = $answer;
    }

    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }
}