<?php

namespace Shanbo\ImmobilierBundle\Command;

use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use Shanbo\ImmobilierBundle\Entity\ShAdresse;
use Shanbo\ImmobilierBundle\Entity\ShAgence;
use Shanbo\ImmobilierBundle\Entity\ShCategorie;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ShanboImmoAgencesCommand extends Command
{
    protected static $defaultName = 'shanbo:immo:agences';

    protected $filenameData = 'agences.xlsx';
    protected $em;
    protected $params;

    protected $pathLoadData;

    public function __construct(EntityManagerInterface $em, ParameterBagInterface $params)
    {
        parent::__construct();

        $this->em = $em;
        $this->params = $params;

        $this->pathLoadData         = $this->params->get('kernel.project_dir') . '/public/data/load/';
    }
    protected function configure()
    {
        $this
            ->setDescription('Ecrase and load data agences')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        // Create categories agence
        $listCategories = array('Location', 'Vente', 'Syndic', 'Gérance');

        $i = 0;
        foreach ($listCategories as $listCategory) {
            if(!$this->em->getRepository(ShCategorie::class)->findOneBy(array('code' => $i))){
                $cat = (new ShCategorie())
                    ->setName($listCategory)
                    ->setCode($i)
                ;

                $this->em->persist($cat);
            }
            $i++;
        }
        $this->em->flush();

        // FILL AGENCE TABLE
        $file = $this->pathLoadData . $this->filenameData;
        if (file_exists($file)) {
            try {
                $reader = IOFactory::createReader('Xlsx');
                $spreadsheet = $reader->load($file);
                $sheetData = $spreadsheet->getActiveSheet()->toArray();

                array_shift($sheetData); // delete first elem array

                if(count($sheetData) != 0){
                    $io->title("Début du traitement des agences");
                    foreach ($sheetData as $offset => $record) {
                        /** @var ShAgence $agence */
                        $agence = $this->em->getRepository(ShAgence::class)->findOneBy(array('dirname' => $record[1]));
                        if($agence){
                            $io->comment($agence->getName());
                            $agence = $this->fillAgence($agence, $record);
                        }else{
                            $io->comment($record[1] . ' n\'existe pas dans le base de donnée.');
                            $agence = new ShAgence();
                            $agence = $this->fillAgence($agence, $record);
                        }
                        $this->em->persist($agence);
                    }
                }
            } catch (Exception $e) {
                $io->error('Erreur lecture des agences xlsx : ' . $e);
            } catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
                $io->error('Erreur activeSheet agences xlsx : ' . $e);
            }
        }else{
            $io->error('Le fichier est : ' . $file);
        }

        $this->em->flush();
    }

    protected function fillAgence(ShAgence $agence, $record){
        $agence->setName($record[0]);
        $agence->setDirname($record[1]);
        $agence->setPhoneLocation($this->setToNullIfEmpty($record[2]));
        $agence->setPhoneVente($this->setToNullIfEmpty($record[3]));
        $agence->setEmail($this->setToNullIfEmpty($record[4]));
        $agence->setWebsite($this->setToNullIfEmpty($record[5]));
        $agence->setLogo($this->setToNullIfEmpty($record[6]));
        $agence->setTarif($this->setToNullIfEmpty($record[17]));
        $agence->setDescription($record[18]);
        $agence->setPhoneStandard($this->setToNullIfEmpty($record[19]));
        $agence->setLegales($record[20]);


        if($record[7] != ""){ // adr
            $adr = (new ShAdresse())
                ->setAdr($this->setToNullIfEmpty($record[7]))
                ->setCp($this->setToNullIfEmpty($record[8]))
                ->setVille($this->setToNullIfEmpty($record[9]))
                ->setArdt($this->setToNullIfEmpty($record[10]))
                ->setlat($this->setToNullIfEmpty($record[11]))
                ->setLon($this->setToNullIfEmpty($record[12]))
            ;

            $this->em->persist($adr);
            $agence->setAdresse($adr);
        }

        /** @var ShCategorie $cats */
        $cats = $this->em->getRepository(ShCategorie::class)->findAll();
        for($i=13; $i<=6; $i++){
            if($record[$i] == "1"){
                switch ($i){
                    case 13:
                        $code = ShCategorie::LOCATION;
                        break;
                    case 14:
                        $code = ShCategorie::VENTE;
                        break;
                    case 15:
                        $code = ShCategorie::SYNDIC;
                        break;
                    default:
                        $code = ShCategorie::GERANCE;
                        break;
                }
                foreach ($cats as $cat) {
                    if($cat->getCode() == $code){
                        $agence->addCategory($cat);
                    }
                }
            }
        }

        return $agence;
    }

    protected function setToNullIfEmpty($record){
        if($record == ""){
            return null;
        }else{
            return $record;
        }
    }
}
