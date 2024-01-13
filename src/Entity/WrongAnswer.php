<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;

#[Entity]
class WrongAnswer extends Answer
{
    #[ORM\ManyToOne(inversedBy: 'wrongAnswers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Question $question = null;

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): void
    {
        $this->question = $question;
    }
}