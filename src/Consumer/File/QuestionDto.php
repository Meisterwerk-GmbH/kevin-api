<?php

namespace App\Consumer\File;

class QuestionDto
{
    /**
     * @param string $question
     * @param string[] $answers
     * @param int $rightAnswer
     */
    public function __construct(
        protected string $question,
        protected array $answers,
        protected int $rightAnswer
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
     * @return string[]
     */
    public function getAnswers(): array
    {
        return $this->answers;
    }

    /**
     * @param string[] $answers
     */
    public function setAnswers(array $answers): void
    {
        $this->answers = $answers;
    }

    public function getRightAnswer(): int
    {
        return $this->rightAnswer;
    }

    public function setRightAnswer(int $rightAnswer): void
    {
        $this->rightAnswer = $rightAnswer;
    }
}