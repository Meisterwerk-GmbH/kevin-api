<?php

namespace App\Consumer\File;

class QuestionsWrapperDto
{
    /**
     * @param QuestionDto[] $questions
     */
    public function __construct(
        protected array $questions
    ){}

    /**
     * @return QuestionDto[]
     */
    public function getQuestions(): array
    {
        return $this->questions;
    }

    /**
     * @param QuestionDto[] $questions
     */
    public function setQuestions(array $questions): void
    {
        $this->questions = $questions;
    }
}