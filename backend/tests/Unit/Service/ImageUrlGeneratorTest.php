<?php

namespace App\Tests\Service;

use App\Service\ImageUrlGenerator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class ImageUrlGeneratorTest extends TestCase
{
    public function testReturnsNullIfNoRequest(): void
    {
        $requestStack = $this->createMock(RequestStack::class);
        $requestStack->method('getCurrentRequest')->willReturn(null);

        $generator = new ImageUrlGenerator($requestStack);

        $this->assertNull($generator->getUrl('image.jpg'));
    }

    public function testReturnsNullIfPathIsEmpty(): void
    {
        $request = new Request();
        $requestStack = $this->createMock(RequestStack::class);
        $requestStack->method('getCurrentRequest')->willReturn($request);

        $generator = new ImageUrlGenerator($requestStack);

        $this->assertNull($generator->getUrl(''));
    }

    public function testGeneratesFullUrl(): void
    {
        $request = new Request([], [], [], [], [], [
            'HTTP_HOST' => 'example.com',
            'HTTPS' => 'on',
        ]);

        $requestStack = $this->createMock(RequestStack::class);
        $requestStack->method('getCurrentRequest')->willReturn($request);

        $generator = new ImageUrlGenerator($requestStack);

        $url = $generator->getUrl('image.jpg');

        $this->assertSame('https://example.com/uploads/products/image.jpg', $url);
    }
}
