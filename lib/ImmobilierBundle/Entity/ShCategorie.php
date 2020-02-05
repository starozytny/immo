<?php

namespace Shanbo\ImmobilierBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Shanbo\ImmobilierBundle\Repository\ShCategorieRepository")
 */
class ShCategorie
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
     * @ORM\Column(type="integer")
     */
    private $code;

    /**
     * @ORM\ManyToMany(targetEntity="Shanbo\ImmobilierBundle\Entity\ShAgence", mappedBy="categories")
     */
    private $agences;

    public function __construct()
    {
        $this->agences = new ArrayCollection();
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

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setCode(int $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return Collection|ShAgence[]
     */
    public function getAgences(): Collection
    {
        return $this->agences;
    }

    public function addAgence(ShAgence $agences): self
    {
        if (!$this->agences->contains($agences)) {
            $this->agences[] = $agences;
            $agences->addCategory($this);
        }

        return $this;
    }

    public function removeAgence(ShAgence $agences): self
    {
        if ($this->agences->contains($agences)) {
            $this->agences->removeElement($agences);
            $agences->removeCategory($this);
        }

        return $this;
    }
}
