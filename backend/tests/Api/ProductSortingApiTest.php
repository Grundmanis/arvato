<?php

namespace App\Tests\Api;

use App\DataFixtures\AppFixtures;
use App\DataFixtures\UserFixture;
use App\Entity\User;
use App\Repository\UserRepository;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductSortingApiTest extends WebTestCase
{
    private KernelBrowser $client;
    private User $user;
    /** @var AbstractDatabaseTool */
    protected $databaseTool;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
        $this->databaseTool->loadFixtures([
            UserFixture::class,
            AppFixtures::class,
        ]);

        $this->user = static::getContainer()->get(UserRepository::class)->findOneBy([]);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->databaseTool);
    }

    public function testGetProductsSortedByRatingDesc(): void
    {
        $this->client->loginUser($this->user);

        $this->client->request('GET', '/api/products?order[rating]=desc');

        $this->assertResponseIsSuccessful();
        $response = $this->client->getResponse();
        $data = json_decode($response->getContent(), true);

        self::assertIsArray($data['hydra:member'] ?? $data);
        $items = $data['hydra:member'] ?? $data;

        // Check rating is sorted descending
        $previous = null;
        foreach ($items as $item) {
            $rating = $item['rating'] ?? 0;
            if (null !== $previous) {
                self::assertLessThanOrEqual($previous, $rating, 'Products not sorted by rating desc');
            }
            $previous = $rating;
        }
    }

    public function testGetProductsSortedByInStockDesc(): void
    {
        $this->client->loginUser($this->user);
        $this->client->request('GET', '/api/products?order[inStock]=desc');

        $this->assertResponseIsSuccessful();

        $response = $this->client->getResponse();
        $content = $response->getContent();

        $data = json_decode($content, true);
        $items = $data['hydra:member'] ?? $data;

        self::assertIsArray($items);
        self::assertNotEmpty($items);

        $previous = null;
        foreach ($items as $item) {
            $inStock = isset($item['inStock']) && $item['inStock'] ? 1 : 0;
            if (null !== $previous) {
                self::assertLessThanOrEqual($previous, $inStock, 'Products not sorted by inStock desc');
            }
            $previous = $inStock;
        }
    }

    public function testGetProductsSortedByCategoryAsc(): void
    {
        $this->client->loginUser($this->user);

        $this->client->request('GET', '/api/products?order[category.name]=asc');

        $this->assertResponseIsSuccessful();
        $response = $this->client->getResponse();
        $data = json_decode($response->getContent(), true);

        $items = $data['hydra:member'] ?? $data;

        $previous = null;
        foreach ($items as $item) {
            $categoryName = $item['category']['name'] ?? '';
            if (null !== $previous) {
                self::assertLessThanOrEqual(strcmp($previous, $categoryName), 0, 'Products not sorted by category asc');
            }
            $previous = $categoryName;
        }
    }
}
