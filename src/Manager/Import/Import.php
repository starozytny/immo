<?php


namespace App\Manager\Import;


use App\Entity\ShAdresse;
use App\Entity\ShAgence;
use App\Entity\ShBien;
use App\Entity\ShCaracteristique;
use App\Entity\ShCommodite;
use App\Entity\ShCopro;
use App\Entity\ShDiagnostic;
use App\Entity\ShFinancier;
use App\Entity\ShImage;
use App\Entity\ShResponsable;
use App\Manager\ImportData\Data\DataAdresse;
use App\Manager\ImportData\Data\DataAgence;
use App\Manager\ImportData\Data\DataBien;
use App\Manager\ImportData\Data\DataCaracteristique;
use App\Manager\ImportData\Data\DataCommodite;
use App\Manager\ImportData\Data\DataCopro;
use App\Manager\ImportData\Data\DataDiagnostic;
use App\Manager\ImportData\Data\DataFinancier;
use App\Manager\ImportData\Data\DataImage;
use App\Manager\ImportData\Data\DataResponsable;
use App\Manager\ImportData\DataSanitize;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Exception;

class Import extends DataSanitize
{
    protected $type;
    protected $record;
    protected $directoryExport;
    private $em;

    public function __construct($directoryExport, EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->directoryExport = $directoryExport;
    }
    public function import($type, $folder, $record, $tabPathImg)
    {
        $this->type = $type;
        $this->record = $this->cleaner($record);

        $bien = $this->createBien($folder);
        if($bien != false){
            $this->createImage($folder, $tabPathImg, $bien);
        }
        $this->em->flush();
    }

    protected function createAgence($folder)
    {
        $data = new DataAgence($this->type, $this->record, $folder);

        if(!$this->isExiste($this->em, ShAgence::class, 'dirname', $data->getDirname())){
            $agence = (new ShAgence())
                ->setName($data->getAgenceName())
                ->setDirname($data->getDirname())
            ;
            $this->em->persist($agence);
            return $agence;
        }else{
            return $this->em->getRepository(ShAgence::class)->findOneBy(array('dirname' => $data->getDirname()));
        }
    }

    protected function createFinancier()
    {
        $data = new DataFinancier($this->type, $this->record);
        $financier = (new ShFinancier())
            ->setPrix($data->getPrix())
            ->setHonoraires($data->getHonoraires())
            ->setCharges($data->getCharges())
            ->setFoncier($data->getFoncier())
            ->setDepotGarantie($data->getDepotGarantie())
            ->setHonoChargesDe($data->getHonoChargesDe())
            ->setHorsHonoAcquereur($data->getHorsHonoAcquereur())
            ->setModalitesChargesLocataire($data->getModalitesChargesLocataire())
            ->setComplementLoyer($data->getComplementLoyer())
            ->setPartHonoEdl($data->getPartHonoEdl())
            ->setBouquet($data->getBouquet())
            ->setRente($data->getRente())
        ;
        $this->em->persist($financier);
        return $financier;
    }

    protected function createCopro()
    {
        $data = new DataCopro($this->type, $this->record);
        $copro = (new ShCopro())
//            ->setIsCopro($data->getisCopro())
            ->setNbLot($data->getNbLot())
            ->setChargesAnnuelle($data->getChargesAnnuelle())
            ->setHasProced($data->getHasProced())
            ->setDetailsProced($data->getDetailsProced())
        ;

        $this->em->persist($copro);
        return $copro;
    }

    protected function createDiagnostic()
    {
        $data = new DataDiagnostic($this->type, $this->record);
        $diag = (new ShDiagnostic())
            ->setDpeval($data->getDpeval())
            ->setDpelettre($data->getDpelettre())
            ->setGesval($data->getGesval())
            ->setGeslettre($data->getGeslettre())
        ;

        $this->em->persist($diag);
        return $diag;
    }

    protected function setResponsable(DataResponsable $data){
        $responsable = (new ShResponsable())
            ->setContact($data->getContact())
            ->setTel($data->getTel())
            ->setEmail($data->getEmail())
            ->setCodeNego($data->getCodeNego())
        ;

        $this->em->persist($responsable);
        return $responsable;
    }
    protected function createResponsable()
    {
        $data = new DataResponsable($this->type, $this->record);
        $contact = $data->getContact();
        if(!$this->isExiste($this->em, ShResponsable::class, 'contact', $contact)){
            return $this->setResponsable($data);
        }else{
            if(!$this->isExiste($this->em, ShResponsable::class, 'tel', $data->getTel())){
                return $this->setResponsable($data);
            }else{
                return $this->em->getRepository(ShResponsable::class)->findOneBy(array('contact' => $contact));
            }
        }
    }

    protected function createCommodite()
    {
        $data = new DataCommodite($this->type, $this->record);
        $commodite = (new ShCommodite())
            ->setHasAscenseur($data->getHasAscenceur())
            ->setHasCave($data->getHasCave())
            ->setHasInterphone($data->getHasInterphone())
            ->setHasGardien($data->getHasGardien())
            ->setHasTerrasse($data->getHasTerrasse())
            ->setHasClim($data->getHasClim())
            ->setHasPiscine($data->getHasPiscine())
            ->setNbParking($data->getNbParking())
            ->setNbBox($data->getNbBox())
        ;

        $this->em->persist($commodite);
        return $commodite;
    }

    protected function createCaracteristique(ShCommodite $commodite)
    {
        $data = new DataCaracteristique($this->type, $this->record);
        $cuisine = $this->specialCaracCuisineXML($data->getCuisine());
        $chauffage = $this->specialCaracChauffageXML($data->getChauffage());
        $hasCommo = 1;
        if($commodite->getHasAscenseur() == 0 && $commodite->getHasCave() == 0 && $commodite->getHasInterphone() == 0
            && $commodite->getHasGardien() == 0 && $commodite->getHasTerrasse() == 0 && $commodite->getHasClim() == 0
            && $commodite->getHasPiscine() == 0 && $commodite->getNbParking() != 0 && $commodite->getNbBox() != 0){
            $hasCommo = 0;
        }

        $carac = (new ShCaracteristique())
            ->setSurface($data->getSurface())
            ->setSurfaceTerrain($data->getSurfaceTerrain())
            ->setSurfaceSejour($data->getSurfaceSejour())
            ->setNbPiece($data->getNbrPiece())
            ->setNbChambre($data->getNbrChambre())
            ->setNbSdb($data->getNbrSdb())
            ->setNbSe($data->getNbrSle())
            ->setNbWc($data->getNbrWc())
            ->setIsWcSepare($data->getisWcSepare())
            ->setNbBalcon($data->getNbrBalcon())
            ->setNbEtage($data->getNbrEtage())
            ->setEtage($data->getEtage())
            ->setIsMeuble($data->getisMeuble())
            ->setAnneeConstruction($data->getAnneeConstruction())
            ->setIsRefaitneuf($data->getisRefaitNeuf())
            ->setTypeChauffage($chauffage)
            ->setTypeCuisine($cuisine)
            ->setIsSud($data->getisSud())
            ->setIsNord($data->getisNord())
            ->setIsEst($data->getisEst())
            ->setIsOuest($data->getisOuest())
            ->setHasCommodite($hasCommo)
            ->setCommodite($commodite)
        ;

        $this->em->persist($carac);

        return $carac;
    }

    protected function createAdresse()
    {
        $data = new DataAdresse($this->type, $this->record);
        $adresse = (new ShAdresse())
            ->setAdr($data->getAdr())
            ->setVille($data->getVille())
            ->setCp($data->getCp())
            ->setArdt($data->getArdt())
            ->setQuartier($data->getQuartier())
            ->setLat($data->getLat())
            ->setLon($data->getLon())
        ;

        $this->em->persist($adresse);
        return $adresse;
    }

    /**
     * @param $folder
     * @return bool|ShBien
     */
    protected function createBien($folder){
        $agence = $this->createAgence($folder);
        $financier = $this->createFinancier();
        $copro = $this->createCopro();
        $diagnostic = $this->createDiagnostic();
        $responsable = $this->createResponsable();
        $commodite = $this->createCommodite();
        $carac = $this->createCaracteristique($commodite);
        $adresse = $this->createAdresse();

        $data = new DataBien($this->type, $this->record);

        $ref = $this->setUniqueRef($data->getRef(), $agence->getId());

        if(!$this->isExiste($this->em, ShBien::class, 'ref', $data->getRef())){

            $reader = new Csv();
            $oldId = null;
            if(file_exists($this->getDirectoryExport() . 'biens.csv')){
                try {
                    $spreadsheet = $reader->load($this->getDirectoryExport() . 'biens.csv');
                    $sheetData = $spreadsheet->getActiveSheet()->toArray();
                    foreach ($sheetData as $item) {
                        if($item[1] == $data->getRealRef() &&
                            $item[2] == $data->getCodeTypeAnnonce() &&
                            $item[3] == $data->getCodeTypeBien() &&
                            $item[4] == $agence->getDirname()
                        ){
                            $oldId = $item[0];
                        }
                    }
                } catch (Exception $e) {
                    var_dump('Error load bien.csv : ' . $e);
                } catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
                    var_dump('Error get active sheet : ' . $e);
                }
            }

            $bien = (new ShBien())
                ->setRef($ref)
                ->setTypeAnnonce($data->getTypeAnnonce())
                ->setTypeBien($data->getTypeBien())
                ->setTypeT($data->getTypeT())
                ->setLibelle($data->getLibelle())
                ->setDescriptif($data->getDescriptif())
                ->setDateDispo($data->getDispo())
                ->setCodeTypeAnnonce($data->getCodeTypeAnnonce())
                ->setCodeTypeBien($data->getCodeTypeBien())
                ->setAgence($agence)
                ->setFinancier($financier)
                ->setCopro($copro)
                ->setResponsable($responsable)
                ->setDiagnostic($diagnostic)
                ->setCaracteristique($carac)
                ->setAdresse($adresse)
                ->setRealRef($data->getRef())
                ->setIsCopro($data->getIsCopro())
                ->setIdentifiant(uniqid($agence->getId().$data->getCodeTypeAnnonce().$data->getCodeTypeBien()))
            ;

            if($oldId != null){
                $bien->setIdentifiant($oldId);
            }

            $this->em->persist($bien);
            return $bien;
        }else{
            var_dump("Le bien de cette référence existe déjà : " . $data->getRef());
            return false;
        }
    }

    private function setUniqueRef($ref, $agenceID){
        $ref = trim($ref);
        $ref = str_replace([" ", "-", "/", "_", "'", "\""], "", $ref);
        if(strlen($ref) > 10){
            $ref = uniqid();
        }
        if(ctype_alpha($ref)){
            $ref = uniqid();
        }
        return $agenceID . "|" . $ref;
    }
    public function getDirectoryExport()
    {
        return $this->directoryExport;
    }

    protected function createImage($folder, $tabPathImg, ShBien $bien)
    {
        $data = new DataImage($this->type, $this->record, $folder, $tabPathImg);
        $tab = $data->getImages();
        $images = array();
        for ($i=0 ; $i < count($tab) ; $i++){

            $file = $tab[$i]->getFile();
            $thumbs = $tab[$i]->getThumbs();

            if($file != null){
                $image = (new ShImage())
                    ->setFile($file)
                    ->setRang($i)
                    ->setOrientation(false)
                    ->setBien($bien)
                ;
                if($i == 0){
                    $image->setThumb($thumbs);
                }
                $this->em->persist($image);
                array_push($images, $image);
            }

        }

        return $images;
    }
}
