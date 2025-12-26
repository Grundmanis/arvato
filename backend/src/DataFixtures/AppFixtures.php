<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\ProductImage;
use App\Entity\ProductReview;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 50; ++$i) {
            $product = new Product();
            $product->setName($faker->words(3, true));
            $product->setCategory($faker->words(2, true));
            $product->setPrice($faker->randomFloat(2, 10, 500));
            $product->setQuantity($faker->numberBetween(0, 5));

            $imageFiles = ['cpu.webp'];
            foreach ($imageFiles as $filename) {
                $image = new ProductImage();
                $image->setPath($filename);
                $product->addImage($image);
            }

            $manager->persist($product);

            $reviewsCount = rand(1, 3);
            for ($j = 0; $j < $reviewsCount; ++$j) {
                $review = new ProductReview();
                $review->setProduct($product);
                $review->setRating(rand(1, 5));
                $review->setComment($faker->sentence(15));

                $manager->persist($review);
            }
        }

        $manager->flush();
    }
}
