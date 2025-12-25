<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

// TODO: add apiResource for filtelrs
#[ApiResource(
    cacheHeaders: [
        'max_age' => 3600,        // cache in browser
        'shared_max_age' => 3600, // cache for reverse proxy
        'vary' => ['Authorization'], // vary cache based on Authorization header
    ]
)]
#[ApiFilter(SearchFilter::class, properties: [
    'name' => 'partial',
    'category' => 'exact',
])]
#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $category = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private ?string $price = null;

    #[ORM\Column(nullable: true)]
    private ?int $quantity = null;

    #[ORM\Column(type: 'uuid', unique: true)]
    private ?Uuid $publicId = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'datetime')]
    private \DateTime $updatedAt;

    /**
     * @var Collection<int, ProductReview>
     */
    #[ORM\OneToMany(mappedBy: 'product', targetEntity: ProductReview::class, orphanRemoval: true)]
    private Collection $reviews;

    public function __construct()
    {
        $this->reviews = new ArrayCollection();
        $this->publicId = Uuid::v4();
    }

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTime();
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        $this->updatedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRating(): float
    {
        if ($this->reviews->isEmpty()) {
            return 0;
        }

        $total = array_sum($this->reviews->map(fn ($r) => $r->getRating())->toArray());

        return round($total / $this->reviews->count(), 2);
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getPrice(): ?float
    {
        return null !== $this->price ? (float) $this->price : null;
    }

    public function setPrice(?float $price): self
    {
        $this->price = null !== $price ? (string) $price : null;

        return $this;
    }

    public function isInStock(): ?bool
    {
        return $this->quantity > 0;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPublicId(): ?Uuid
    {
        return $this->publicId;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }
}
