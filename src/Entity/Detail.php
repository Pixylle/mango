<?php

namespace App\Entity;

use App\Repository\DetailRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DetailRepository::class)]
class Detail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Plat::class, inversedBy: 'details')]
    private ?Plat $plat = null;

    #[ORM\ManyToOne(targetEntity: Commande::class, inversedBy: 'details')]
    private ?Commande $commande = null;

    // Исправляем тип для quantite на int
    #[ORM\Column(type: 'integer')]
    private ?int $quantite = 0; // начальное значение по умолчанию

    // Геттеры и сеттеры
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlat(): ?Plat
    {
        return $this->plat;
    }

    public function setPlat(?Plat $plat): static
    {
        $this->plat = $plat;

        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): static
    {
        $this->commande = $commande;

        return $this;
    }

    // Геттер и сеттер для quantite
    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }
}
