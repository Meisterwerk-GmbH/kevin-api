<?php

namespace App\State;

use ApiPlatform\Doctrine\Orm\Paginator;
use ApiPlatform\Doctrine\Orm\State\CollectionProvider;
use ApiPlatform\Doctrine\Orm\State\ItemProvider;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\Pagination;
use ApiPlatform\State\Pagination\TraversablePaginator;
use ApiPlatform\State\ProviderInterface;
use App\Dto\AnswerOutput;
use App\Dto\QuestionOutput;
use App\Entity\Answer;
use App\Entity\Question;
use Symfony\Component\Serializer\SerializerInterface;

class QuestionProvider implements ProviderInterface
{
    public function __construct(
        protected CollectionProvider $collectionProvider,
        protected ItemProvider $itemProvider,
        protected SerializerInterface $serializer,
        protected Pagination $pagination,
    ) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $entities = $this->collectionProvider->provide($operation, $uriVariables, $context);
        assert($entities instanceof Paginator);
        $dtos = array_map(fn($q) => $this->mapEntityToDto($q), iterator_to_array($entities));
        return new TraversablePaginator(
            new \ArrayIterator($dtos),
            $entities->getCurrentPage(),
            $entities->getItemsPerPage(),
            $entities->getTotalItems()
        );
    }

    protected function mapEntityToDto(Question $question): QuestionOutput {
        return new QuestionOutput(
            $question->getId(),
            $question->getQuestion(),
            array_map(
                fn($q) => new AnswerOutput($q->getUuid(), $q->getAnswer()),
                $this->shuffleAnswers($question)
            )
        );
    }

    /**
     * @return Answer[]
     */
    protected function shuffleAnswers(Question $question): array {
        $randomPosition = rand(0, $question->getAnswers()->count());
        $shuffledAnswers = $question->getAnswers()->toArray();
        array_splice( $shuffledAnswers, $randomPosition, 0, [$question->getRightAnswer()]);
        return $shuffledAnswers;
    }
}