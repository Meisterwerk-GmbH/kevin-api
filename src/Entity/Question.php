<?php

namespace App\Entity;

use ApiPlatform\Metadata\GetCollection;
use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
#[GetCollection(normalizationContext: ['groups' => ['question']])]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('question')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups('question')]
    private ?string $question = null;

    #[ORM\OneToMany(mappedBy: 'question', targetEntity: Answer::class, cascade: ['persist'], orphanRemoval: true)]
    #[Groups('question')]
    private Collection $answers;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[Groups('question')]
    private ?Answer $rightAnswer = null;

    public function __construct()
    {
        $this->answers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): static
    {
        $this->question = $question;

        return $this;
    }

    /**
     * @return Collection<int, Answer>
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function addAnswer(Answer $answer): static
    {
        if (!$this->answers->contains($answer)) {
            $this->answers->add($answer);
            $answer->setQuestion($this);
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): static
    {
        if ($this->answers->removeElement($answer)) {
            // set the owning side to null (unless already changed)
            if ($answer->getQuestion() === $this) {
                $answer->setQuestion(null);
            }
        }

        return $this;
    }

    public function getRightAnswer(): ?Answer
    {
        return $this->rightAnswer;
    }

    public function setRightAnswer(Answer $rightAnswer): static
    {
        $rightAnswer->setQuestion($this);
        $this->rightAnswer = $rightAnswer;
        return $this;
    }
}
