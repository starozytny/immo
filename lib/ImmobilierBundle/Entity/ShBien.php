<?php

namespace Shanbo\ImmobilierBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Shanbo\ImmobilierBundle\Repository\ShBienRepository")
 */
class ShBien
{
    const TYPE_LOCATION = 0;
    const TYPE_VENTE = 1;

    const TYPE_MAISON = 0;
    const TYPE_APPARTEMENT = 1;
    const TYPE_PARKING = 2;
    const TYPE_BUREAUX = 3;
    const TYPE_LOCAL = 4;
    const TYPE_IMMEUBLE = 5;
    const TYPE_TERRAIN = 6;
    const TYPE_FOND_COMMERCE = 7;

    const ALL_TYPE = array(0,1,2,3,4,5,6,7);

    const SLUG_LOCATION = 'locations';
    const SLUG_VENTE = 'ventes';

    const SLUG_MAISON = 'maison';
    const SLUG_APPARTEMENT = 'appartement';
    const SLUG_PARKING = 'parking';
    const SLUG_BUREAUX = 'bureaux';
    const SLUG_LOCAL = 'local';
    const SLUG_IMMEUBLE = 'immeuble';
    const SLUG_TERRAIN = 'terrain';
    const SLUG_FOND_COMMERCE = 'fond-commerce';
    const SLUG_AUTRE = 'autre';
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ref;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $real_ref;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type_annonce;

    /**
     * @ORM\Column(type="integer")
     */
    private $code_type_annonce;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type_bien;

    /**
     * @ORM\Column(type="integer")
     */
    private $code_type_bien;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private $type_t;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $libelle;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $descriptif;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_dispo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $identifiant;

    /**
     * @ORM\Column(type="integer")
     */
    private $is_copro;

    /**
     * @ORM\ManyToOne(targetEntity="Shanbo\ImmobilierBundle\Entity\ShAgence", fetch="EAGER", inversedBy="biens")
     * @ORM\JoinColumn(nullable=false)
     */
    private $agence;

    /**
     * @ORM\OneToOne(targetEntity="Shanbo\ImmobilierBundle\Entity\ShFinancier", fetch="EAGER", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $financier;

    /**
     * @ORM\OneToOne(targetEntity="Shanbo\ImmobilierBundle\Entity\ShCopro", fetch="EAGER", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $copro;

    /**
     * @ORM\ManyToOne(targetEntity="Shanbo\ImmobilierBundle\Entity\ShResponsable", fetch="EAGER", inversedBy="shBiens")
     * @ORM\JoinColumn(nullable=true)
     */
    private $responsable;

    /**
     * @ORM\OneToOne(targetEntity="Shanbo\ImmobilierBundle\Entity\ShDiagnostic", fetch="EAGER", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $diagnostic;

    /**
     * @ORM\OneToOne(targetEntity="Shanbo\ImmobilierBundle\Entity\ShCaracteristique", fetch="EAGER", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $caracteristique;

    /**
     * @ORM\OneToOne(targetEntity="Shanbo\ImmobilierBundle\Entity\ShAdresse", fetch="EAGER", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $adresse;

    /**
     * @ORM\OneToMany(targetEntity="Shanbo\ImmobilierBundle\Entity\ShImage", fetch="EAGER", mappedBy="bien", orphanRemoval=true)
     */
    private $images;

    /**
     * @ORM\OneToMany(targetEntity="Shanbo\ImmobilierBundle\Entity\ShDemande", fetch="EAGER", mappedBy="bien", orphanRemoval=true)
     */
    private $demandes;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->demandes = new ArrayCollection();
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRef(): ?string
    {
        return $this->ref;
    }

    public function setRef(string $ref): self
    {
        $this->ref = $ref;

        return $this;
    }

    public function getRealRef(): ?string
    {
        return $this->real_ref;
    }

    public function setRealRef(string $real_ref): self
    {
        $this->real_ref = $real_ref;

        return $this;
    }

    public function getTypeAnnonce(): ?string
    {
        return $this->type_annonce;
    }

    public function setTypeAnnonce(?string $type_annonce): self
    {
        $this->type_annonce = $type_annonce;

        return $this;
    }

    public function getCodeTypeAnnonce(): ?int
    {
        return $this->code_type_annonce;
    }

    public function setCodeTypeAnnonce(int $code_type_annonce): self
    {
        $this->code_type_annonce = $code_type_annonce;

        return $this;
    }

    public function getTypeBien(): ?string
    {
        return $this->type_bien;
    }

    public function setTypeBien(string $type_bien): self
    {
        $this->type_bien = $type_bien;

        return $this;
    }

    public function getCodeTypeBien(): ?int
    {
        return $this->code_type_bien;
    }

    public function setCodeTypeBien(int $code_type_bien): self
    {
        $this->code_type_bien = $code_type_bien;

        return $this;
    }

    public function getTypeT(): ?string
    {
        return $this->type_t;
    }

    public function setTypeT(?string $type_t): self
    {
        $this->type_t = $type_t;

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getDescriptif(): ?string
    {
        return $this->descriptif;
    }

    public function setDescriptif(?string $descriptif): self
    {
        $this->descriptif = $descriptif;

        return $this;
    }

    public function getDateDispo(): ?\DateTimeInterface
    {
        return $this->date_dispo;
    }

    public function setDateDispo(?\DateTimeInterface $date_dispo): self
    {
        $this->date_dispo = $date_dispo;

        return $this;
    }

    public function getIdentifiant(): ?string
    {
        return $this->identifiant;
    }

    public function setIdentifiant(string $identifiant): self
    {
        $this->identifiant = $identifiant;

        return $this;
    }

    public function getIsCopro(): ?int
    {
        return $this->is_copro;
    }

    public function setIsCopro(int $is_copro): self
    {
        $this->is_copro = $is_copro;

        return $this;
    }

    public function getAgence(): ?ShAgence
    {
        return $this->agence;
    }

    public function setAgence(?ShAgence $agence): self
    {
        $this->agence = $agence;

        return $this;
    }

    public function getFinancier(): ?ShFinancier
    {
        return $this->financier;
    }

    public function setFinancier(ShFinancier $financier): self
    {
        $this->financier = $financier;

        return $this;
    }

    public function getCopro(): ?ShCopro
    {
        return $this->copro;
    }

    public function setCopro(ShCopro $copro): self
    {
        $this->copro = $copro;

        return $this;
    }

    public function getResponsable(): ?ShResponsable
    {
        return $this->responsable;
    }

    public function setResponsable(?ShResponsable $responsable): self
    {
        $this->responsable = $responsable;

        return $this;
    }

    public function getDiagnostic(): ?ShDiagnostic
    {
        return $this->diagnostic;
    }

    public function setDiagnostic(ShDiagnostic $diagnostic): self
    {
        $this->diagnostic = $diagnostic;

        return $this;
    }

    public function getCaracteristique(): ?ShCaracteristique
    {
        return $this->caracteristique;
    }

    public function setCaracteristique(ShCaracteristique $caracteristique): self
    {
        $this->caracteristique = $caracteristique;

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
     * @return Collection|ShImage[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(ShImage $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setBien($this);
        }

        return $this;
    }

    public function removeImage(ShImage $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getBien() === $this) {
                $image->setBien(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ShDemande[]
     */
    public function getDemandes(): Collection
    {
        return $this->demandes;
    }

    public function addDemande(ShDemande $demande): self
    {
        if (!$this->demandes->contains($demande)) {
            $this->demandes[] = $demande;
            $demande->setBien($this);
        }

        return $this;
    }

    public function removeDemande(ShDemande $demande): self
    {
        if ($this->demandes->contains($demande)) {
            $this->demandes->removeElement($demande);
            // set the owning side to null (unless already changed)
            if ($demande->getBien() === $this) {
                $demande->setBien(null);
            }
        }

        return $this;
    }

    public function getSlugTypeAnnonce()
    {
        switch ($this->getCodeTypeAnnonce()) {
            case ShBien::TYPE_LOCATION:
                return ShBien::SLUG_LOCATION;
                break;
            default:
                return ShBien::SLUG_VENTE;
                break;
        }
    }

    public function getSlugTypeBien()
    {
        switch ($this->getCodeTypeBien()) {
            case ShBien::TYPE_MAISON:
                return ShBien::SLUG_MAISON;
                break;
            case ShBien::TYPE_APPARTEMENT:
                return ShBien::SLUG_APPARTEMENT;
                break;
            case ShBien::TYPE_PARKING:
                return ShBien::SLUG_PARKING;
                break;
            case ShBien::TYPE_BUREAUX:
                return ShBien::SLUG_BUREAUX;
                break;
            case ShBien::TYPE_LOCAL:
                return ShBien::SLUG_LOCAL;
                break;
            case ShBien::TYPE_IMMEUBLE:
                return ShBien::SLUG_IMMEUBLE;
                break;
            case ShBien::TYPE_TERRAIN:
                return ShBien::SLUG_TERRAIN;
                break;
            case ShBien::TYPE_FOND_COMMERCE:
                return ShBien::SLUG_FOND_COMMERCE;
                break;
            default:
                return ShBien::SLUG_AUTRE;
                break;
        }
    }

    public function getSlugRef(){
        $ref = $this->getRef();
        $pos = strpos($ref,'|');
        $ref = substr($ref, $pos+1, strlen($ref));
        $ref = str_replace('/','-',$ref);

        return $ref;
    }

    public function __toString()
    {
        return $this->getRef() . ' - ' . $this->getLibelle();
    }
}
