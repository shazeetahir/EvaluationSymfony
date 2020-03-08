<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContinentRepository")
 */
class Continent
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Decouvert", mappedBy="continent")
     */
    private $decouverts;

    public function __construct()
    {
        $this->decouverts = new ArrayCollection();
    }

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

    /**
     * @return Collection|Decouvert[]
     */
    public function getDecouverts(): Collection
    {
        return $this->decouverts;
    }

    public function addDecouvert(Decouvert $decouvert): self
    {
        if (!$this->decouverts->contains($decouvert)) {
            $this->decouverts[] = $decouvert;
            $decouvert->setContinent($this);
        }

        return $this;
    }

    public function removeDecouvert(Decouvert $decouvert): self
    {
        if ($this->decouverts->contains($decouvert)) {
            $this->decouverts->removeElement($decouvert);
            // set the owning side to null (unless already changed)
            if ($decouvert->getContinent() === $this) {
                $decouvert->setContinent(null);
            }
        }

        return $this;
    }
}
