<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\RequestStack;

class ImageUrlGenerator
{
    public function __construct(private RequestStack $requestStack)
    {
    }

    public function getUrl(string $path): ?string
    {
        $request = $this->requestStack->getCurrentRequest();
        if (!$request || !$path) {
            return null;
        }

        return $request->getSchemeAndHttpHost().'/uploads/products/'.$path;
    }
}
