<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findAllCategories(): array
    {
        $categories = $this->createQueryBuilder('p')
            ->select('DISTINCT p.category')
            ->getQuery()
            ->getScalarResult();

        return array_map(fn($row) => $row['category'], $categories);
    }

    public function findAllNames(): array
    {
        $names = $this->createQueryBuilder('p')
            ->select('DISTINCT p.name')
            ->getQuery()
            ->getScalarResult();

        return array_map(fn($row) => $row['name'], $names);
    }
}
