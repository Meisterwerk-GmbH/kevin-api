<?php

namespace App\Filter;

use ApiPlatform\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\PropertyInfo\Type;
use Doctrine\DBAL\Types\Types;

class GuesserFilter extends AbstractFilter
{
    protected function filterProperty(string $property, $value, QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, Operation $operation = null, array $context = []): void
    {
        $guesserParam = $queryNameGenerator->generateParameterName('guesser');
        $questionAlias = $queryBuilder->getRootAliases()[0];
        $guesserAlias = $queryNameGenerator->generateJoinAlias('guessers');
        $queryBuilder
            ->leftJoin(
                sprintf('%s.guesses', $questionAlias),
                $guesserAlias,
                Expr\Join::WITH,
                sprintf('%s.question = %s.id and %s.guesser = :%s', $guesserAlias, $questionAlias, $guesserAlias, $guesserParam)
            )
            ->andWhere(sprintf('%s.id IS NULL', $guesserAlias))
            ->setParameter($guesserParam, $value, Types::STRING);
    }

    public function getDescription(string $resourceClass): array
    {
        return [
            'guesser' => [
                'type' => Type::BUILTIN_TYPE_STRING,
                'required' => true,
                'description' => 'Filter for the guesser with its identifier.',
            ]
        ];
    }
}