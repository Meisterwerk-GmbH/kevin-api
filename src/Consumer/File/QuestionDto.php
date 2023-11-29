<?php

namespace App\Consumer\File;

class QuestionDto
{
    /**
     * @param string[] $wrongAnswers
     */
    public function __construct(
        protected string $question,
        protected array  $wrongAnswers,
        protected string $rightAnswer
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
    public function getWrongAnswers(): array
    {
        return $this->wrongAnswers;
    }

    /**
     * @param string[] $wrongAnswers
     */
    public function setWrongAnswers(array $wrongAnswers): void
    {
        $this->wrongAnswers = $wrongAnswers;
    }

    public function getRightAnswer(): string
    {
        return $this->rightAnswer;
    }

    public function setRightAnswer(string $rightAnswer): void
    {
        $this->rightAnswer = $rightAnswer;
    }
}