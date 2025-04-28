<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $products = null;
    #[ORM\Column(type: 'string')]
    private string $nom;

    #[ORM\Column(type: 'float')]
    private float $prix;

    #[ORM\Column(type: 'string')]
    private string $image;
public function getId(): ?int
    {
        return $this->id;
    }

    public function getProducts(): ?string
    {
        return $this->products;
    }

    public function setProducts(string $products): static
    {
        $this->products = $products;

        return $this;
    }
}
