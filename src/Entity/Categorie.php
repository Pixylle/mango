<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['categorie:read', 'plat:read'])] // Разрешаем ID в JSON
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['categorie:read', 'plat:read'])] // Название категории
    private ?string $libelle = null;

    /**
     * @var Collection<int, Plat>
     */
    #[ORM\OneToMany(targetEntity: Plat::class, mappedBy: 'categorie', orphanRemoval: true)]
    private Collection $plats; // ❌ УБИРАЕМ ИЗ JSON, ЧТОБЫ НЕ БЫЛО ЗАЦИКЛИВАНИЯ!

    #[ORM\Column(length: 255)]
    #[Groups(['categorie:read'])] // Показываем изображение категории
    private ?string $image = null;

    #[ORM\Column]
    #[Groups(['categorie:read'])] // Показываем активность категории
    private ?bool $active = null;

    public function __construct()
    {
        $this->plats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;
        return $this;
    }

    /**
     * @return Collection<int, Plat>
     */
    public function getPlats(): Collection
    {
        return $this->plats;
    }

    public function addPlat(Plat $plat): static
    {
        if (!$this->plats->contains($plat)) {
            $this->plats->add($plat);
            $plat->setCategorie($this);
        }
        return $this;
    }

    public function removePlat(Plat $plat): static
    {
        if ($this->plats->removeElement($plat)) {
            if ($plat->getCategorie() === $this) {
                $plat->setCategorie(null);
            }
        }
        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;
        return $this;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;
        return $this;
    }
}
