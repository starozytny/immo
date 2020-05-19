<?php

namespace Shanbo\ImmobilierBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Shanbo\ImmobilierBundle\Repository\ShAgenceRepository")
 */
class ShAgence
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
     * @ORM\Column(type="string", length=255)
     */
    private $dirname;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $legales;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $logo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tarif;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $website;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $phone_standard;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $phone_location;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $phone_vente;

    /**
     * @ORM\OneToOne(targetEntity="Shanbo\ImmobilierBundle\Entity\ShAdresse", fetch="EAGER", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $adresse;

    /**
     * @ORM\OneToMany(targetEntity="Shanbo\ImmobilierBundle\Entity\ShBien", mappedBy="agence", orphanRemoval=true)
     */
    private $biens;

    /**
     * @ORM\ManyToMany(targetEntity="Shanbo\ImmobilierBundle\Entity\ShCategorie", inversedBy="agences")
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity="Shanbo\ImmobilierBundle\Entity\ShStatAgence", mappedBy="agence")
     */
    private $stats;
    
        /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email_location;
    
        /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email_vente;

    public function __construct()
    {
        $this->biens = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->stats = new ArrayCollection();
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

    public function getDirname(): ?string
    {
        return $this->dirname;
    }

    public function setDirname(string $dirname): self
    {
        $this->dirname = $dirname;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getLegales(): ?string
    {
        return $this->legales;
    }

    public function setLegales(?string $legales): self
    {
        $this->legales = $legales;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getTarif(): ?string
    {
        return $this->tarif;
    }

    public function setTarif(?string $tarif): self
    {
        $this->tarif = $tarif;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): self
    {
        $this->website = $website;

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
    
    public function getEmailLocation(): ?string
    {
        return $this->email_location;
    }

    public function setEmailLocation(?string $email): self
    {
        $this->email_location = $email;

        return $this;
    }
    
    public function getEmailVente(): ?string
    {
        return $this->email_vente;
    }

    public function setEmailVente(?string $email): self
    {
        $this->email_vente = $email;

        return $this;
    }

    public function getPhoneStandard(): ?string
    {
        return $this->phone_standard;
    }

    public function setPhoneStandard(?string $phone_standard): self
    {
        $this->phone_standard = $phone_standard;

        return $this;
    }

    public function getPhoneLocation(): ?string
    {
        return $this->phone_location;
    }

    public function setPhoneLocation(?string $phone_location): self
    {
        $this->phone_location = $phone_location;

        return $this;
    }

    public function getPhoneVente(): ?string
    {
        return $this->phone_vente;
    }

    public function setPhoneVente(?string $phone_vente): self
    {
        $this->phone_vente = $phone_vente;

        return $this;
    }

    public function getAdresse(): ?ShAdresse
    {
        return $this->adresse;
    }

    public function setAdresse(ShAdresse $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * @return Collection|ShBien[]
     */
    public function getBiens(): Collection
    {
        return $this->biens;
    }

    public function addBien(ShBien $bien): self
    {
        if (!$this->biens->contains($bien)) {
            $this->biens[] = $bien;
            $bien->setAgence($this);
        }

        return $this;
    }

    public function removeBien(ShBien $bien): self
    {
        if ($this->biens->contains($bien)) {
            $this->biens->removeElement($bien);
            // set the owning side to null (unless already changed)
            if ($bien->getAgence() === $this) {
                $bien->setAgence(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ShCategorie[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(ShCategorie $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(ShCategorie $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
        }

        return $this;
    }

    /**
     * @return Collection|ShStatAgence[]
     */
    public function getStats(): Collection
    {
        return $this->stats;
    }

    public function addStat(ShStatAgence $stat): self
    {
        if (!$this->stats->contains($stat)) {
            $this->stats[] = $stat;
            $stat->setAgence($this);
        }

        return $this;
    }

    public function removeStat(ShStatAgence $stat): self
    {
        if ($this->stats->contains($stat)) {
            $this->stats->removeElement($stat);
            // set the owning side to null (unless already changed)
            if ($stat->getAgence() === $this) {
                $stat->setAgence(null);
            }
        }

        return $this;
    }
}
