<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use symfony\component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[UniqueEntity('name')]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    #[Assert\Length(min: 2, max: 50)]
    private ?string $name = null;

    #[ORM\Column(length: 255, type: Types::TEXT)]
    #[Assert\NotBlank()]
    private string $description;

    #[ORM\Column]
    private ?float $PBT = null;

    #[ORM\Column(nullable: true)]
    private ?bool $visible = null;

    #[ORM\Column(nullable: true)]
    private ?bool $OnSale = null;

    #[ORM\ManyToOne(inversedBy: 'Products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateCreated = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $Description): self
    {
        $this->description = $Description;

        return $this;
    }

    public function getPBT(): ?float
    {
        return $this->PBT;
    }

    public function setPBT(float $PBT): self
    {
        $this->PBT = $PBT;

        return $this;
    }

    public function isVisible(): ?bool
    {
        return $this->visible;
    }

    public function setVisible(?bool $visible): self
    {
        $this->visible = $visible;

        return $this;
    }

    public function isOnSale(): ?bool
    {
        return $this->OnSale;
    }

    public function setOnSale(?bool $OnSale): self
    {
        $this->OnSale = $OnSale;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateCreated(?\DateTimeInterface $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }
}
