<?php

namespace App\Serializer;

use App\Entity\ProductImage;
use App\Service\ImageUrlGenerator;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ProductImageNormalizer implements NormalizerInterface
{
    public function __construct(private ImageUrlGenerator $imageUrlGenerator)
    {
    }

    public function supportsNormalization($data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof ProductImage;
    }

    public function normalize(mixed $object, ?string $format = null, array $context = []): array|string|int|float|bool|\ArrayObject|null
    {
        return [
            'id' => $object->getId(),
            'path' => $object->getPath(),
            'url' => $this->imageUrlGenerator->getUrl($object->getPath()),
        ];
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            ProductImage::class => true,
        ];
    }
}
