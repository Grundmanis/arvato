<?php

namespace App\Doctrine\Extension;

use ApiPlatform\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use App\Entity\Product;
use Doctrine\ORM\QueryBuilder;
use Psr\Log\LoggerInterface;

class SortInStockExtension implements QueryCollectionExtensionInterface
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    public function applyToCollection(
        QueryBuilder $qb,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        ?Operation $operation = null,
        array $context = [],
    ): void {
        if (Product::class !== $resourceClass) {
            return;
        }

        $filters = $context['filters'] ?? [];
        $order = $filters['order'] ?? [];

        if (!isset($order['inStock'])) {
            return;
        }

        $direction = 'DESC' === strtoupper($order['inStock']) ? 'DESC' : 'ASC';

        $rootAlias = $qb->getRootAliases()[0];

        $qb->addSelect("(CASE WHEN {$rootAlias}.quantity > 0 THEN 1 ELSE 0 END) AS HIDDEN inStockSort")
            ->addOrderBy('inStockSort', $direction);

        unset($order['inStock']);
    }
}
