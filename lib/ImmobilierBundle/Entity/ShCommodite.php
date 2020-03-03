<?php

namespace Shanbo\ImmobilierBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Shanbo\ImmobilierBundle\Repository\ShCommoditeRepository")
 */
class ShCommodite
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $has_ascenseur;

    /**
     * @ORM\Column(type="integer")
     */
    private $has_cave;

    /**
     * @ORM\Column(type="integer")
     */
    private $has_interphone;

    /**
     * @ORM\Column(type="integer")
     */
    private $has_gardien;

    /**
     * @ORM\Column(type="integer")
     */
    private $has_terrasse;

    /**
     * @ORM\Column(type="integer")
     */
    private $has_clim;

    /**
     * @ORM\Column(type="integer")
     */
    private $has_piscine;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nb_parking;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nb_box;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHasAscenseur(): ?int
    {
        return $this->has_ascenseur;
    }

    public function setHasAscenseur(int $has_ascenseur): self
    {
        $this->has_ascenseur = $has_ascenseur;

        return $this;
    }

    public function getHasCave(): ?int
    {
        return $this->has_cave;
    }

    public function setHasCave(int $has_cave): self
    {
        $this->has_cave = $has_cave;

        return $this;
    }

    public function getHasInterphone(): ?int
    {
        return $this->has_interphone;
    }

    public function setHasInterphone(int $has_interphone): self
    {
        $this->has_interphone = $has_interphone;

        return $this;
    }

    public function getHasGardien(): ?int
    {
        return $this->has_gardien;
    }

    public function setHasGardien(int $has_gardien): self
    {
        $this->has_gardien = $has_gardien;

        return $this;
    }

    public function getHasTerrasse(): ?int
    {
        return $this->has_terrasse;
    }

    public function setHasTerrasse(int $has_terrasse): self
    {
        $this->has_terrasse = $has_terrasse;

        return $this;
    }

    public function getHasClim(): ?int
    {
        return $this->has_clim;
    }

    public function setHasClim(int $has_clim): self
    {
        $this->has_clim = $has_clim;

        return $this;
    }

    public function getHasPiscine(): ?int
    {
        return $this->has_piscine;
    }

    public function setHasPiscine(int $has_piscine): self
    {
        $this->has_piscine = $has_piscine;

        return $this;
    }

    public function getNbParking(): ?int
    {
        return $this->nb_parking;
    }

    public function setNbParking(?int $nb_parking): self
    {
        $this->nb_parking = $nb_parking;

        return $this;
    }

    public function getNbBox(): ?int
    {
        return $this->nb_box;
    }

    public function setNbBox(?int $nb_box): self
    {
        $this->nb_box = $nb_box;

        return $this;
    }
}
