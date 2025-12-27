<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    // cacheHeaders: [
    //     'max_age' => 3600,        // cache in browser
    //     'shared_max_age' => 3600, // cache for reverse proxy
    //     'vary' => ['Authorization'], // vary cache based on Authorization header
    // ],
    order: ['createdAt' => 'DESC'],
    normalizationContext: ['groups' => ['product:read']],
    denormalizationContext: ['groups' => ['product:write']],
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
        new Put(),
        new Patch(),
        new Delete(),
    ]
)]
#[ApiFilter(SearchFilter::class, properties: [
    'name' => 'partial',
    'category' => 'exact',
])]

#[ApiFilter(OrderFilter::class, properties: ['quantity', 'price', 'category', 'name', 'id', 'rating', 'inStock'])]
#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['product:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['product:read', 'product:write'])]
    #[Assert\NotBlank(message: "Name is required.")]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['product:read', 'product:write'])]
    #[Assert\NotBlank(message: "Category is required.")]
    // should be a separate Category entity
    private ?string $category = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    #[Groups(['product:read', 'product:write'])]
    #[Assert\NotBlank(message: "Price is required.")]
    #[Assert\Type(type: 'numeric', message: "Price must be a number.")]
    private ?string $price = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['product:read', 'product:write'])]
    private ?int $quantity = null;

    #[ORM\Column(type: 'uuid', unique: true)]
    #[Groups(['product:read'])]
    private ?Uuid $publicId = null;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['product:read'])]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['product:read'])]
    private \DateTime $updatedAt;

    /**
     * @var Collection<int, ProductReview>
     */
    #[ORM\OneToMany(mappedBy: 'product', targetEntity: ProductReview::class, orphanRemoval: true)]
    private Collection $reviews;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: ProductImage::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[Groups(['product:read', 'product:write'])]
    private Collection $images;

    public function __construct()
    {
        $this->reviews = new ArrayCollection();
        $this->publicId = Uuid::v4();
        // TODO: fix types
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTime();
        $this->images = new ArrayCollection();
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


    #[Groups(['product:read'])]
    public function getRating(): float
    {
        if ($this->reviews->isEmpty()) {
            return 0;
        }

        $total = array_sum($this->reviews->map(fn($r) => $r->getRating())->toArray());

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

    #[Groups(['product:read'])]
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

    public function getImages(): Collection
    {
        return $this->images;
    }


    #[Groups(['product:read'])]
    public function getMainImage(): ?ProductImage
    {
        if (!$this->images->isEmpty()) {
            return $this->images->first();
        }
        return null;
    }

    public function addImage(ProductImage $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setProduct($this);
        }
        return $this;
    }

    public function removeImage(ProductImage $image): self
    {
        if ($this->images->removeElement($image)) {
            if ($image->getProduct() === $this) {
                $image->setProduct(null);
            }
        }
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function getReviews(): Collection
    {
        return $this->reviews;
    }
}
