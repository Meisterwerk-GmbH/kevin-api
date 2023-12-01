<?php

namespace App\ApiResource;

class QuestionDto
{
    public function __construct(
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
     * @return AnswerDto[]
     */
    public function getAnswers(): array
    {
        return $this->answers;
    }

    /**
     * @param AnswerDto[] $answers
     */
    public function setAnswers(array $answers): void
    {
        $this->answers = $answers;
    }
}