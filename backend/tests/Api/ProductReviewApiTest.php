<?php

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\DataFixtures\AppFixtures;
use App\DataFixtures\UserFixture;
use App\Repository\ProductRepository;
use App\Repository\ProductReviewRepository;
use App\Repository\UserRepository;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;

class ProductReviewApiTest extends ApiTestCase
{
    /** @var AbstractDatabaseTool */
    protected $databaseTool;

    protected $client;

    protected $user;

    protected $product;

    protected $productReview;

    protected static ?bool $alwaysBootKernel = true;

    public function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();

        $this->databaseTool->loadFixtures([
            UserFixture::class,
            AppFixtures::class,
        ]);

        $this->user = static::getContainer()->get(UserRepository::class)
            ->findOneByEmail('api@local.test');

        $this->product = static::getContainer()
            ->get(ProductRepository::class)
            ->findAll()[0];

        $this->productReview = static::getContainer()
            ->get(ProductReviewRepository::class)
            ->findAll()[0];
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->databaseTool);
    }

    public function testAnonymousCannotGetCollection(): void
    {
        $this->client->request('GET', '/api/product_reviews');
        self::assertResponseStatusCodeSame(401);
    }

    public function testGetCollection(): void
    {
        $this->client->loginUser($this->user);
        $response = $this->client->request('GET', '/api/product_reviews');

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            '@context' => '/api/contexts/ProductReview',
        ]);

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $data = json_decode($content, true);

        self::assertResponseIsSuccessful();
        self::assertIsArray($data);
        self::assertNotEmpty($data);
    }

    public function testGetItem(): void
    {
        $this->client->loginUser($this->user);
        $response = $this->client->request('GET', '/api/product_reviews/'.$this->productReview->getId());

        $this->assertResponseIsSuccessful();

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $data = json_decode($content, true);

        self::assertIsArray($data);
        self::assertArrayHasKey('id', $data);
        self::assertSame($this->productReview->getId(), $data['id']);
    }

    public function testDeleteItem(): void
    {
        $this->client->loginUser($this->user);
        $id = $this->productReview->getId();

        $this->client->request('DELETE', '/api/product_reviews/'.$id);

        $this->assertResponseStatusCodeSame(204);

        $productReview = static::getContainer()->get(ProductReviewRepository::class)->find($id);
        $this->assertNull($productReview, 'productReview should be deleted from the database');
    }

    public function testPatchItem(): void
    {
        $this->client->loginUser($this->user);
        $id = $this->productReview->getId();

        $response = $this->client->request('PATCH', '/api/product_reviews/'.$id, [
            'headers' => ['Content-Type' => 'application/merge-patch+json'],
            'json' => [
                'comment' => 'updated',
            ],
        ]);

        $this->assertResponseIsSuccessful();

        $data = $response->toArray();
        self::assertSame('updated', $data['comment']);
    }
}
