<?php

namespace App\Dto;

use Ramsey\Uuid\UuidInterface;

class AnswerOutput
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