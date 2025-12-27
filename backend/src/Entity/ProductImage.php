<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
class ProductImage
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    #[Groups(['product:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: false)]
    #[Groups(['product:read', 'product:write'])]
    private ?string $path = null;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'images')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;

    private ?File $file = null;

    public function setFile(?File $file = null): self
    {
        $this->file = $file;

        return $this;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    #[Groups(['product:read'])]
    public function getUrl(): ?string
    {
        return $this->path ? '/uploads/products/'.$this->path : null;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function uploadFile(): void
    {
        if (!$this->file) {
            return;
        }

        $filename = uniqid().'.'.$this->file->guessExtension();
        $this->file->move(__DIR__.'/../../public/uploads/products', $filename);
        $this->setPath($filename);
    }
}
