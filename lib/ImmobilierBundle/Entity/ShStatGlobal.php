<?php

namespace Shanbo\ImmobilierBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Shanbo\ImmobilierBundle\Repository\ShStatGlobalRepository")
 */
class ShStatGlobal
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
    private $total_ventes;

    /**
     * @ORM\Column(type="integer")
     */
    private $total_locations;

    /**
     * @ORM\Column(type="integer")
     */
    private $total_users;

    /**
     * @ORM\Column(type="integer")
     */
    private $tot_m;

    /**
     * @ORM\Column(type="integer")
     */
    private $tot_a;

    /**
     * @ORM\Column(type="integer")
     */
    private $tot_p;

    /**
     * @ORM\Column(type="integer")
     */
    private $tot_b;

    /**
     * @ORM\Column(type="integer")
     */
    private $tot_l;

    /**
     * @ORM\Column(type="integer")
     */
    private $tot_i;

    /**
     * @ORM\Column(type="integer")
     */
    private $tot_t;

    /**
     * @ORM\Column(type="integer")
     */
    private $tot_f;

    /**
     * @ORM\Column(type="integer")
     */
    private $tot_autres;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createAt;

    public function __construct()
    {
        $this->setCreateAt(new DateTime());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTotalVentes(): ?int
    {
        return $this->total_ventes;
    }

    public function setTotalVentes(int $total_ventes): self
    {
        $this->total_ventes = $total_ventes;

        return $this;
    }

    public function getTotalLocations(): ?int
    {
        return $this->total_locations;
    }

    public function setTotalLocations(int $total_locations): self
    {
        $this->total_locations = $total_locations;

        return $this;
    }

    public function getTotalUsers(): ?int
    {
        return $this->total_users;
    }

    public function setTotalUsers(int $total_users): self
    {
        $this->total_users = $total_users;

        return $this;
    }

    public function getTotM(): ?int
    {
        return $this->tot_m;
    }

    public function setTotM(int $tot_m): self
    {
        $this->tot_m = $tot_m;

        return $this;
    }

    public function getTotA(): ?int
    {
        return $this->tot_a;
    }

    public function setTotA(int $tot_a): self
    {
        $this->tot_a = $tot_a;

        return $this;
    }

    public function getTotP(): ?int
    {
        return $this->tot_p;
    }

    public function setTotP(int $tot_p): self
    {
        $this->tot_p = $tot_p;

        return $this;
    }

    public function getTotB(): ?int
    {
        return $this->tot_b;
    }

    public function setTotB(int $tot_b): self
    {
        $this->tot_b = $tot_b;

        return $this;
    }

    public function getTotL(): ?int
    {
        return $this->tot_l;
    }

    public function setTotL(int $tot_l): self
    {
        $this->tot_l = $tot_l;

        return $this;
    }

    public function getTotI(): ?int
    {
        return $this->tot_i;
    }

    public function setTotI(int $tot_i): self
    {
        $this->tot_i = $tot_i;

        return $this;
    }

    public function getTotT(): ?int
    {
        return $this->tot_t;
    }

    public function setTotT(int $tot_t): self
    {
        $this->tot_t = $tot_t;

        return $this;
    }

    public function getTotF(): ?int
    {
        return $this->tot_f;
    }

    public function setTotF(int $tot_f): self
    {
        $this->tot_f = $tot_f;

        return $this;
    }

    public function getTotAutres(): ?int
    {
        return $this->tot_autres;
    }

    public function setTotAutres(int $tot_autres): self
    {
        $this->tot_autres = $tot_autres;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeInterface $create_at): self
    {
        $this->createAt = $create_at;

        return $this;
    }
}
