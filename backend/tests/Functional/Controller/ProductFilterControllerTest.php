<?php

namespace App\Tests\Controller;

use App\DataFixtures\AppFixtures;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use \App\DataFixtures\UserFixture;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;

final class ProductFilterControllerTest extends WebTestCase
{
    /** @var AbstractDatabaseTool */
    protected $databaseTool;

    protected $client;

    protected $user;

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
    }

    public function testAnonymousCannotAccessCategories(): void
    {
        $this->client->request('GET', '/api/filters/products/categories');
        self::assertResponseStatusCodeSame(401);
    }

    public function testAuthenticatedAccessCategories(): void
    {
        $this->client->loginUser($this->user);
        $this->client->request('GET', '/api/filters/products/categories');
        $response = $this->client->getResponse();
        $content = $response->getContent();
        $data = json_decode($content, true);

        self::assertResponseIsSuccessful();
        self::assertIsArray($data);
        self::assertNotEmpty($data);
    }

    public function testAnonymousCannotAccessNames(): void
    {
        $this->client->request('GET', '/api/filters/products/names');
        self::assertResponseStatusCodeSame(401);
    }

    public function testAuthenticatedAccessNames(): void
    {
        $this->client->loginUser($this->user);
        $this->client->request('GET', '/api/filters/products/names');

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $data = json_decode($content, true);

        self::assertResponseIsSuccessful();
        self::assertIsArray($data);
        self::assertNotEmpty($data);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->databaseTool);
    }
}
