<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class ProductFilterController extends AbstractController
{
    #[Route('/api/filters/products/categories', name: 'product_categories', methods: ['GET'])]
    public function categories(EntityManagerInterface $em, Request $request): JsonResponse
    {
        $categories = $em->getRepository(Product::class)
            ->createQueryBuilder('p')
            ->select('DISTINCT p.category')
            ->getQuery()
            ->getScalarResult();

        $categories = array_map(fn($row) => $row['category'], $categories);

        $response = new JsonResponse($categories);

        return $response;
    }

    #[Route('/api/filters/products/names', name: 'product_names', methods: ['GET'])]
    public function names(EntityManagerInterface $em, Request $request): JsonResponse
    {
        $names = $em->getRepository(Product::class)
            ->createQueryBuilder('p')
            ->select('DISTINCT p.name')
            ->getQuery()
            ->getScalarResult();

        $names = array_map(fn($row) => $row['name'], $names);

        $response = new JsonResponse($names);

        return $response;
    }
}
