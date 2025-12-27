<?php

namespace App\Tests\Entity;

use App\Entity\Product;
use App\Entity\ProductImage;
use App\Entity\ProductReview;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function testGetRatingNoReviews(): void
    {
        $product = new Product();
        $this->assertSame(0.0, $product->getRating());
    }

    public function testGetRatingWithReviews(): void
    {
        $product = new Product();

        $review1 = $this->createMock(ProductReview::class);
        $review1->method('getRating')->willReturn(4);

        $review2 = $this->createMock(ProductReview::class);
        $review2->method('getRating')->willReturn(5);

        $product->getReviews()->add($review1);
        $product->getReviews()->add($review2);

        $this->assertSame(4.5, $product->getRating());
    }

    public function testIsInStockReturnsFalse()
    {
        $product = new Product();
        $product->setQuantity(0);

        $this->assertSame(false, $product->isInStock());
    }

    public function testIsInStockReturnsTrue()
    {
        $product = new Product();
        $product->setQuantity(1);

        $this->assertSame(true, $product->isInStock());
    }

    public function testMainImageIsNotReturned()
    {
        $product = new Product();
        $this->assertSame(null, $product->getMainImage());
    }

    public function testMainImageIsReturned()
    {
        $product = new Product();
        $productImage = new ProductImage();
        $product->addImage($productImage);
        $this->assertSame($productImage, $product->getMainImage());
    }
}
