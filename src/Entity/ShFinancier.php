<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ShFinancierRepository")
 */
class ShFinancier
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $honoraires;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $charges;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $foncier;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $depot_garantie;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $hono_charges_de;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $hors_hono_acquereur;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $modalites_charges_locataire;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $complement_loyer;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $part_hono_edl;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $bouquet;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $rente;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getHonoraires(): ?float
    {
        return $this->honoraires;
    }

    public function setHonoraires(?float $honoraires): self
    {
        $this->honoraires = $honoraires;

        return $this;
    }

    public function getCharges(): ?float
    {
        return $this->charges;
    }

    public function setCharges(?float $charges): self
    {
        $this->charges = $charges;

        return $this;
    }

    public function getFoncier(): ?float
    {
        return $this->foncier;
    }

    public function setFoncier(?float $foncier): self
    {
        $this->foncier = $foncier;

        return $this;
    }

    public function getDepotGarantie(): ?float
    {
        return $this->depot_garantie;
    }

    public function setDepotGarantie(?float $depot_garantie): self
    {
        $this->depot_garantie = $depot_garantie;

        return $this;
    }

    public function getHonoChargesDe(): ?string
    {
        return $this->hono_charges_de;
    }

    public function setHonoChargesDe(?string $hono_charges_de): self
    {
        $this->hono_charges_de = $hono_charges_de;

        return $this;
    }

    public function getHorsHonoAcquereur(): ?float
    {
        return $this->hors_hono_acquereur;
    }

    public function setHorsHonoAcquereur(?float $hors_hono_acquereur): self
    {
        $this->hors_hono_acquereur = $hors_hono_acquereur;

        return $this;
    }

    public function getModalitesChargesLocataire(): ?string
    {
        return $this->modalites_charges_locataire;
    }

    public function setModalitesChargesLocataire(?string $modalites_charges_locataire): self
    {
        $this->modalites_charges_locataire = $modalites_charges_locataire;

        return $this;
    }

    public function getComplementLoyer(): ?float
    {
        return $this->complement_loyer;
    }

    public function setComplementLoyer(?float $complement_loyer): self
    {
        $this->complement_loyer = $complement_loyer;

        return $this;
    }

    public function getPartHonoEdl(): ?float
    {
        return $this->part_hono_edl;
    }

    public function setPartHonoEdl(?float $part_hono_edl): self
    {
        $this->part_hono_edl = $part_hono_edl;

        return $this;
    }

    public function getBouquet(): ?float
    {
        return $this->bouquet;
    }

    public function setBouquet(?float $bouquet): self
    {
        $this->bouquet = $bouquet;

        return $this;
    }

    public function getRente(): ?float
    {
        return $this->rente;
    }

    public function setRente(?float $rente): self
    {
        $this->rente = $rente;

        return $this;
    }
}
