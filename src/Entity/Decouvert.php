<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DecouvertRepository")
 */
class Decouvert
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    // /**
    //  * @ORM\Column(type="string", length=255)
    //  */
    // private $continent;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Continent", inversedBy="decouverts")
     */
    private $continent;

    public function getId(): ?int
    {
        return $this->id;
    }

    // public function getContinent(): ?string
    // {
    //     return $this->continent;
    // }

    // public function setContinent(string $continent): self
    // {
    //     $this->continent = $continent;

    //     return $this;
    // }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage( $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getContinent(): ?Continent
    {
        return $this->continent;
    }

    public function setContinent(?Continent $continent): self
    {
        $this->continent = $continent;

        return $this;
    }
}
