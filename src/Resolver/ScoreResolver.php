<?php

namespace App\Resolver;

use ApiPlatform\GraphQl\Resolver\QueryItemResolverInterface;
use App\Entity\Score;
use App\Repository\GuessRepository;

final class ScoreResolver implements QueryItemResolverInterface
{
    public function __construct(
        private GuessRepository $guessRepository
    ) {}

    /**
     * @param Score|null $item
     * @param array $context
     * @return Score
     */
    public function __invoke($item, array $context): Score
    {
        $guesser = $context['args']['id'];
        return new Score(
            $guesser,
            array_reduce(
                $this->guessRepository->findBy(['guesser' => $guesser]),
                fn($s, $g) =>
                    $g->getAnswer()->getId() === $g->getQuestion()->getRightAnswer()->getId() ? $s + 1 : $s,
                0
        ));
    }
}