<?php

namespace App\EventListeners;

use App\Entity\Product;
use Symfony\Contracts\Cache\CacheInterface;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\PostRemoveEventArgs;
use Doctrine\ORM\Event\PostUpdateEventArgs;
use Doctrine\ORM\Events;

#[AsDoctrineListener(event: Events::postPersist)]
#[AsDoctrineListener(event: Events::postUpdate)]
#[AsDoctrineListener(event: Events::postRemove)]
final class ProductListener
{
    private CacheInterface $cache;

    public function __construct(CacheInterface $cache)
    {
        $this->cache = $cache;
    }

    public function postPersist(PostPersistEventArgs $args): void
    {
        $this->invalidateCache($args->getObject());
    }

    public function postUpdate(PostUpdateEventArgs $args): void
    {
        $this->invalidateCache($args->getObject());
    }

    public function postRemove(PostRemoveEventArgs $args): void
    {
        $this->invalidateCache($args->getObject());
    }

    private function invalidateCache(object $entity): void
    {
        if (!$entity instanceof Product) {
            return;
        }

        $this->cache->delete('product_categories_list');
        $this->cache->delete('product_names_list');
    }
}
