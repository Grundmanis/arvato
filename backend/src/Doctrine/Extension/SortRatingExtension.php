<?php

namespace App\Doctrine\Extension;

use ApiPlatform\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use App\Entity\Product;
use Doctrine\ORM\QueryBuilder;

class SortRatingExtension implements QueryCollectionExtensionInterface
{
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

        // Check if filters exist and if rating is requested
        $filters = $context['filters'] ?? [];
        $order = $filters['order'] ?? [];

        if (!isset($order['rating'])) {
            return;
        }

        $direction = 'DESC' === strtoupper($order['rating']) ? 'DESC' : 'ASC';
        $rootAlias = $qb->getRootAliases()[0];
        $qb->addSelect("(SELECT AVG(r2.rating) FROM App\\Entity\\ProductReview r2 WHERE r2.product = {$rootAlias}) AS HIDDEN ratingSort")
            ->addOrderBy('ratingSort', $direction);
    }
}
