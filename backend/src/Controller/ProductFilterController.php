<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class ProductFilterController extends AbstractController
{
    #[Route('/api/filters/products/categories', name: 'product_categories', methods: ['GET'])]
    public function categories(ProductRepository $productRepository): JsonResponse
    {
        $categories = $productRepository->findAllCategories();
        return new JsonResponse($categories);
    }

    #[Route('/api/filters/products/names', name: 'product_names', methods: ['GET'])]
    public function names(ProductRepository $productRepository): JsonResponse
    {
        $names = $productRepository->findAllNames();
        return new JsonResponse($names);
    }
}
