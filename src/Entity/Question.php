<?php

namespace App\Entity;

use ApiPlatform\Metadata\GetCollection;
use App\ApiResource\QuestionDto;
use App\Repository\QuestionRepository;
use App\State\QuestionProvider;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
#[GetCollection(
    output: QuestionDto::class,
    provider: QuestionProvider::class
)]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $question = null;

    #[ORM\OneToMany(mappedBy: 'question', targetEntity: WrongAnswer::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $wrongAnswers;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Answer $rightAnswer = null;

    public function __construct()
    {
        $this->wrongAnswers = new ArrayCollection();
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
     * @return Collection<int, WrongAnswer>
     */
    public function getWrongAnswers(): Collection
    {
        return $this->wrongAnswers;
    }

    public function addWrongAnswer(WrongAnswer $answer): static
    {
        if (!$this->wrongAnswers->contains($answer)) {
            $this->wrongAnswers->add($answer);
            $answer->setQuestion($this);
        }

        return $this;
    }

    public function removeWrongAnswer(WrongAnswer $answer): static
    {
        if ($this->wrongAnswers->removeElement($answer)) {
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
        $this->rightAnswer = $rightAnswer;
        return $this;
    }
}
