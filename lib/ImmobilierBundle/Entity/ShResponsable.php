<?php

namespace Shanbo\ImmobilierBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Shanbo\ImmobilierBundle\Repository\ShResponsableRepository")
 */
class ShResponsable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contact;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $tel;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $code_nego;

    /**
     * @ORM\OneToMany(targetEntity="Shanbo\ImmobilierBundle\Entity\ShBien", mappedBy="responsable")
     */
    private $shBiens;

    public function __construct()
    {
        $this->shBiens = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(?string $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(?string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getCodeNego(): ?string
    {
        return $this->code_nego;
    }

    public function setCodeNego(?string $code_nego): self
    {
        $this->code_nego = $code_nego;

        return $this;
    }

    /**
     * @return Collection|ShBien[]
     */
    public function getShBiens(): Collection
    {
        return $this->shBiens;
    }

    public function addShBien(ShBien $shBien): self
    {
        if (!$this->shBiens->contains($shBien)) {
            $this->shBiens[] = $shBien;
            $shBien->setResponsable($this);
        }

        return $this;
    }

    public function removeShBien(ShBien $shBien): self
    {
        if ($this->shBiens->contains($shBien)) {
            $this->shBiens->removeElement($shBien);
            // set the owning side to null (unless already changed)
            if ($shBien->getResponsable() === $this) {
                $shBien->setResponsable(null);
            }
        }

        return $this;
    }
}
