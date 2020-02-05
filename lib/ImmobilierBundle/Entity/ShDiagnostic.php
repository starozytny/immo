<?php

namespace Shanbo\ImmobilierBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Shanbo\ImmobilierBundle\Repository\ShDiagnosticRepository")
 */
class ShDiagnostic
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
    private $dpe_val;

    /**
     * @ORM\Column(type="string", length=3, nullable=true)
     */
    private $dpe_lettre;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ges_val;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private $ges_lettre;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDpeVal(): ?int
    {
        return $this->dpe_val;
    }

    public function setDpeVal(?int $dpe_val): self
    {
        $this->dpe_val = $dpe_val;

        return $this;
    }

    public function getDpeLettre(): ?string
    {
        return $this->dpe_lettre;
    }

    public function setDpeLettre(?string $dpe_lettre): self
    {
        $this->dpe_lettre = $dpe_lettre;

        return $this;
    }

    public function getGesVal(): ?int
    {
        return $this->ges_val;
    }

    public function setGesVal(?int $ges_val): self
    {
        $this->ges_val = $ges_val;

        return $this;
    }

    public function getGesLettre(): ?string
    {
        return $this->ges_lettre;
    }

    public function setGesLettre(?string $ges_lettre): self
    {
        $this->ges_lettre = $ges_lettre;

        return $this;
    }
}
