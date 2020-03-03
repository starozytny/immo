<?php

namespace Shanbo\ImmobilierBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Shanbo\ImmobilierBundle\Repository\ShCaracteristiqueRepository")
 */
class ShCaracteristique
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $has_commodite;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $surface;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $surface_terrain;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $surface_sejour;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nb_piece;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nb_chambre;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nb_sdb;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nb_se;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nb_wc;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $is_wc_separe;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nb_balcon;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nb_etage;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $etage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $annee_construction;

    /**
     * @ORM\Column(type="integer")
     */
    private $is_refaitneuf;

    /**
     * @ORM\Column(type="integer")
     */
    private $is_meuble;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type_chauffage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type_cuisine;

    /**
     * @ORM\Column(type="integer")
     */
    private $is_sud;

    /**
     * @ORM\Column(type="integer")
     */
    private $is_nord;

    /**
     * @ORM\Column(type="integer")
     */
    private $is_est;

    /**
     * @ORM\Column(type="integer")
     */
    private $is_ouest;

    /**
     * @ORM\OneToOne(targetEntity="Shanbo\ImmobilierBundle\Entity\ShCommodite", cascade={"persist", "remove"})
     */
    private $commodite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHasCommodite(): ?bool
    {
        return $this->has_commodite;
    }

    public function setHasCommodite(bool $has_commodite): self
    {
        $this->has_commodite = $has_commodite;

        return $this;
    }

    public function getSurface(): ?float
    {
        return $this->surface;
    }

    public function setSurface(?float $surface): self
    {
        $this->surface = $surface;

        return $this;
    }

    public function getSurfaceTerrain(): ?float
    {
        return $this->surface_terrain;
    }

    public function setSurfaceTerrain(?float $surface_terrain): self
    {
        $this->surface_terrain = $surface_terrain;

        return $this;
    }

    public function getSurfaceSejour(): ?float
    {
        return $this->surface_sejour;
    }

    public function setSurfaceSejour(?float $surface_sejour): self
    {
        $this->surface_sejour = $surface_sejour;

        return $this;
    }

    public function getNbPiece(): ?int
    {
        return $this->nb_piece;
    }

    public function setNbPiece(?int $nb_piece): self
    {
        $this->nb_piece = $nb_piece;

        return $this;
    }

    public function getNbChambre(): ?int
    {
        return $this->nb_chambre;
    }

    public function setNbChambre(?int $nb_chambre): self
    {
        $this->nb_chambre = $nb_chambre;

        return $this;
    }

    public function getNbSdb(): ?int
    {
        return $this->nb_sdb;
    }

    public function setNbSdb(?int $nb_sdb): self
    {
        $this->nb_sdb = $nb_sdb;

        return $this;
    }

    public function getNbSe(): ?int
    {
        return $this->nb_se;
    }

    public function setNbSe(?int $nb_se): self
    {
        $this->nb_se = $nb_se;

        return $this;
    }

    public function getNbWc(): ?int
    {
        return $this->nb_wc;
    }

    public function setNbWc(?int $nb_wc): self
    {
        $this->nb_wc = $nb_wc;

        return $this;
    }

    public function getIsWcSepare(): ?int
    {
        return $this->is_wc_separe;
    }

    public function setIsWcSepare(?int $is_wc_separe): self
    {
        $this->is_wc_separe = $is_wc_separe;

        return $this;
    }

    public function getNbBalcon(): ?int
    {
        return $this->nb_balcon;
    }

    public function setNbBalcon(?int $nb_balcon): self
    {
        $this->nb_balcon = $nb_balcon;

        return $this;
    }

    public function getNbEtage(): ?int
    {
        return $this->nb_etage;
    }

    public function setNbEtage(?int $nb_etage): self
    {
        $this->nb_etage = $nb_etage;

        return $this;
    }

    public function getEtage(): ?int
    {
        return $this->etage;
    }

    public function setEtage(?int $etage): self
    {
        $this->etage = $etage;

        return $this;
    }

    public function getAnneeConstruction(): ?string
    {
        return $this->annee_construction;
    }

    public function setAnneeConstruction(?string $annee_construction): self
    {
        $this->annee_construction = $annee_construction;

        return $this;
    }

    public function getIsRefaitneuf(): ?int
    {
        return $this->is_refaitneuf;
    }

    public function setIsRefaitneuf(int $is_refaitneuf): self
    {
        $this->is_refaitneuf = $is_refaitneuf;

        return $this;
    }

    public function getIsMeuble(): ?int
    {
        return $this->is_meuble;
    }

    public function setIsMeuble(int $is_meuble): self
    {
        $this->is_meuble = $is_meuble;

        return $this;
    }

    public function getTypeChauffage(): ?string
    {
        return $this->type_chauffage;
    }

    public function setTypeChauffage(?string $type_chauffage): self
    {
        $this->type_chauffage = $type_chauffage;

        return $this;
    }

    public function getTypeCuisine(): ?string
    {
        return $this->type_cuisine;
    }

    public function setTypeCuisine(?string $type_cuisine): self
    {
        $this->type_cuisine = $type_cuisine;

        return $this;
    }

    public function getIsSud(): ?int
    {
        return $this->is_sud;
    }

    public function setIsSud(int $is_sud): self
    {
        $this->is_sud = $is_sud;

        return $this;
    }

    public function getIsNord(): ?int
    {
        return $this->is_nord;
    }

    public function setIsNord(int $is_nord): self
    {
        $this->is_nord = $is_nord;

        return $this;
    }

    public function getIsEst(): ?int
    {
        return $this->is_est;
    }

    public function setIsEst(int $is_est): self
    {
        $this->is_est = $is_est;

        return $this;
    }

    public function getIsOuest(): ?int
    {
        return $this->is_ouest;
    }

    public function setIsOuest(int $is_ouest): self
    {
        $this->is_ouest = $is_ouest;

        return $this;
    }

    public function getCommodite(): ?ShCommodite
    {
        return $this->commodite;
    }

    public function setCommodite(?ShCommodite $commodite): self
    {
        $this->commodite = $commodite;

        return $this;
    }
}
