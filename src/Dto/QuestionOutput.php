<?php

namespace App\Dto;

class QuestionOutput
{
    public function __construct(
        protected int $id,
        protected string $question,
        protected array $answers
    ) {}

    public function getQuestion(): string
    {
        return $this->question;
    }

    public function setQuestion(string $question): void
    {
        $this->question = $question;
    }

    /**
     * @return AnswerOutput[]
     */
    public function getAnswers(): array
    {
        return $this->answers;
    }

    /**
     * @param AnswerOutput[] $answers
     */
    public function setAnswers(array $answers): void
    {
        $this->answers = $answers;
    }

    public function getId(): int
    {
        return $this->id;
    }
}