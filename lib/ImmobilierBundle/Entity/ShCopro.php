<?php

namespace Shanbo\ImmobilierBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Shanbo\ImmobilierBundle\Repository\ShCoproRepository")
 */
class ShCopro
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nb_lot;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $charges_annuelle;

    /**
     * @ORM\Column(type="integer")
     */
    private $has_proced;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $details_proced;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbLot(): ?int
    {
        return $this->nb_lot;
    }

    public function setNbLot(?int $nb_lot): self
    {
        $this->nb_lot = $nb_lot;

        return $this;
    }

    public function getChargesAnnuelle(): ?int
    {
        return $this->charges_annuelle;
    }

    public function setChargesAnnuelle(?int $charges_annuelle): self
    {
        $this->charges_annuelle = $charges_annuelle;

        return $this;
    }

    public function getHasProced(): ?int
    {
        return $this->has_proced;
    }

    public function setHasProced(int $has_proced): self
    {
        $this->has_proced = $has_proced;

        return $this;
    }

    public function getDetailsProced(): ?string
    {
        return $this->details_proced;
    }

    public function setDetailsProced(?string $details_proced): self
    {
        $this->details_proced = $details_proced;

        return $this;
    }
}
