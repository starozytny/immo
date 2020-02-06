<?php

namespace Shanbo\ImmobilierBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Shanbo\ImmobilierBundle\Repository\ShDemandeRepository")
 */
class ShDemande
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $telephone;

    /**
     * @ORM\Column(type="text")
     */
    private $message;

    /**
     * @ORM\Column(type="datetime")
     */
    private $create_at;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isSeen;

    /**
     * @ORM\ManyToOne(targetEntity="Shanbo\ImmobilierBundle\Entity\ShBien", inversedBy="demandes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $bien;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->create_at;
    }

    public function setCreateAt(\DateTimeInterface $create_at): self
    {
        $this->create_at = $create_at;

        return $this;
    }

    public function getIsSeen(): ?bool
    {
        return $this->isSeen;
    }

    public function setIsSeen(bool $is_seen): self
    {
        $this->isSeen = $is_seen;

        return $this;
    }

    public function getBien(): ?ShBien
    {
        return $this->bien;
    }

    public function setBien(?ShBien $bien): self
    {
        $this->bien = $bien;

        return $this;
    }
}
