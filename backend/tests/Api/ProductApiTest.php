<?php

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use \App\DataFixtures\UserFixture;
use App\DataFixtures\AppFixtures;
use App\Repository\UserRepository;
use App\Repository\ProductRepository;

class ProductApiTest extends ApiTestCase
{
    /** @var AbstractDatabaseTool */
    protected $databaseTool;

    protected $client;

    protected $user;

    protected $product;

    protected static ?bool $alwaysBootKernel = true;

    public function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();

        $this->databaseTool->loadFixtures([
            UserFixture::class,
            AppFixtures::class
        ]);

        $this->user = static::getContainer()->get(UserRepository::class)
            ->findOneByEmail('api@local.test');

        $this->product = static::getContainer()
            ->get(ProductRepository::class)
            ->findOneBy(['quantity' => ['gt' => 1]]);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->databaseTool);
    }

    public function testAnonymousCannotGetCollection(): void
    {
        $this->client->request('GET', '/api/products');
        self::assertResponseStatusCodeSame(401);
    }

    public function testGetCollection(): void
    {
        $this->client->loginUser($this->user);
        $response = $this->client->request('GET', '/api/products');

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            '@context' => '/api/contexts/Product',
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
        $response = $this->client->request('GET', '/api/products/' . $this->product->getId());

        $this->assertResponseIsSuccessful();

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $data = json_decode($content, true);

        self::assertIsArray($data);
        self::assertArrayHasKey('id', $data);
        self::assertSame($this->product->getId(), $data['id']);
        self::assertSame($this->product->isInStock(), true);
    }

    // TODO: test deletee what doesnt exist
    public function testDeleteItem(): void
    {
        $this->client->loginUser($this->user);
        $id = $this->product->getId();

        $this->client->request('DELETE', '/api/products/' . $id);

        $this->assertResponseStatusCodeSame(204);

        $product = static::getContainer()->get(ProductRepository::class)->find($id);
        $this->assertNull($product, 'Product should be deleted from the database');
    }

    public function testPutItem(): void
    {
        $this->client->loginUser($this->user);
        $id = $this->product->getId();

        $this->client->request('PUT', '/api/products/' . $id, [
            'headers' => ['Content-Type' => 'application/ld+json'],
            'json' => [
                'name' => 'Updated Product Name',
                'category' => $this->product->getCategory(),
                'price' => "222.123"
            ],
        ]);

        $this->assertResponseIsSuccessful();

        $response = $this->client->getResponse();
        $data = json_decode($response->getContent(), true);

        self::assertSame('Updated Product Name', $data['name']);
        self::assertSame(222.123, $data['price']);
    }

    public function testPutItemValidation(): void
    {
        $this->client->loginUser($this->user);
        $id = $this->product->getId();

        $this->client->request('PUT', '/api/products/' . $id, [
            'headers' => ['Content-Type' => 'application/ld+json'],
            'json' => [
                'name' => 'Updated Product Name',
                'category' => $this->product->getCategory(),
            ],
        ]);

        $this->assertResponseStatusCodeSame(422);
    }

    public function testPatchItem(): void
    {
        $this->client->loginUser($this->user);
        $id = $this->product->getId();

        $response = $this->client->request('PATCH', '/api/products/' . $id, [
            'headers' => ['Content-Type' => 'application/merge-patch+json'],
            'json' => [
                'name' => 'Patched Name',
            ],
        ]);

        $this->assertResponseIsSuccessful();

        $data = $response->toArray();
        self::assertSame('Patched Name', $data['name']);
    }
}
