<?php

namespace Shanbo\ImmobilierBundle\Command;

use League\Csv\Reader;
use PhpOffice\PhpSpreadsheet\Exception;
use Shanbo\ImmobilierBundle\Entity\ShAdresse;
use Shanbo\ImmobilierBundle\Entity\ShAgence;
use Shanbo\ImmobilierBundle\Manager\Image\ImageManager;
use Shanbo\ImmobilierBundle\Manager\Import\Import;
use Doctrine\DBAL\ConnectionException;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use ZipArchive;

class ShanboImmoCommand extends Command
{
    protected static $defaultName = 'shanbo:immo';
    protected $filenameData = 'annonces.csv';
    protected $filenameDataMaj = 'Annonces.csv';

    const ANNONCE_CSV = 0;
    const ANNONCE_XML = 1;
    const ANNONCE_JSON = 2;

    protected $PATH_DATA;
    protected $PATH_DEPOT;
    protected $PATH_EXTRACT;
    protected $PATH_ARCHIVE;
    protected $PATH_ANNONCES;
    protected $PATH_IMAGES;
    protected $PATH_THUMBS;

    protected $listEntity;

    private $em;
    private $params;
    private $import;
    private $imageManager;

    public function __construct(EntityManagerInterface $em, ParameterBagInterface $params, Import $import, ImageManager $imageManager)
    {
        parent::__construct();
        $this->em = $em;
        $this->params = $params;
        $this->import = $import;
        $this->imageManager = $imageManager;
        $path_public = $this->params->get('kernel.project_dir') . '/public/';

        $this->PATH_DATA = $path_public . 'data/';
        $this->PATH_DEPOT = $path_public . 'data/depot/';
        $this->PATH_EXTRACT = $path_public . 'data/extract/';
        $this->PATH_ARCHIVE = $path_public . 'data/archive/';

        $this->PATH_ANNONCES = $path_public . 'annonces/';
        $this->PATH_IMAGES = $path_public . 'annonces/images/';
        $this->PATH_THUMBS = $path_public . 'annonces/thumbs/';

        $this->listEntity = [
            'sh_bien',
            'sh_financier',
            'sh_copro',
            'sh_diagnostic',
            'sh_responsable',
            'sh_caracteristique',
            'sh_commodite',
            'sh_image'
        ];
    }

    protected function configure()
    {
        $this
            ->setDescription('Import CSV XML to database')
            ->addArgument('appel', InputArgument::REQUIRED, '1 si premier appel 0 sinon');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // --------------  INITIALISATION DES DOSSIERS  -----------------------
        $folders = array($this->PATH_DATA, $this->PATH_DEPOT, $this->PATH_EXTRACT, $this->PATH_ARCHIVE,
                         $this->PATH_ANNONCES, $this->PATH_IMAGES, $this->PATH_THUMBS);
        $this->createDir($folders);

        // --------------  PROCESSUS  -----------------------
        $appel = $input->getArgument('appel');
        $this->process($appel, $io, $output);
        return 1;
    }

    protected function process($appel, SymfonyStyle $io, OutputInterface $output)
    {
        // --------------  RECHERCHE DES ZIP  -----------------------
        $io->title('Recherche et décompression des zips');
        $archives = scandir($this->PATH_DEPOT);
        $folders = $this->extractZIP($archives, $io); // exit auto if no folder

        // --------------  SET VAR FOR IMAGEMANAGER  -----------------------
        $this->imageManager->setIo($io);
        $this->imageManager->setPathExtract($this->PATH_EXTRACT);
        $this->imageManager->setPathImg($this->PATH_IMAGES);
        $this->imageManager->setPathThumb($this->PATH_THUMBS);

        if($folders == 0){
            if($appel != 1){
                // --------------  ADD STAT  -----------------------
                $io->title('Sauvegarde des stats');
                $command = $this->getApplication()->find('shanbo:immo:stats');
                $arguments = [
                    'command' => 'shanbo:immo:stats'
                ];
                $greetInput = new ArrayInput($arguments);
                try {
                    $command->run($greetInput, $output);
                } catch (\Exception $e) {
                    $io->error('Erreur run cmd stats : ' . $e);
                }
            }

            $io->success('Fin de la commande');
            return 0;
        }else {

            // -------------- SI CEST LE PREMIER APPEL  -----------------------
            if($appel == 1){
                // --------------  SAVE OLD DATA  -----------------------
                $io->title('Sauvegarde des anciens identifiants des biens');
                $command = $this->getApplication()->find('shanbo:immo:old');
                $arguments = [
                    'command' => 'shanbo:immo:old'
                ];
                $greetInput = new ArrayInput($arguments);
                try {
                    $command->run($greetInput, $output);
                } catch (\Exception $e) {
                    $io->error('Erreur run cmd old immo : ' . $e);
                }
                // --------------  RESET TABLE  -----------------------
                $io->title('Reset des tables');
                try {
                    $this->resetTable($io);
                } catch (ConnectionException $e) {$io->error("ConnectionException : " . $e);
                } catch (DBALException $e) {$io->error("DBALException : " . $e);}
            }

            // --------------  START PROCESS FOLDER  -----------------------
            $folder = $folders[0]; // get first folder
            $archives = $this->getOriginalArchives($archives);
            $archive = $archives[0];

            // --------------  Reinitialise les dossiers images du folder + MOVE IMG TO PUBLIC  -----------------------
            $io->comment('Suppression des images de ' . $folder);
            $this->deleteFolder($this->PATH_IMAGES . $folder);
            $this->deleteFolder($this->PATH_THUMBS . $folder);
            $io->title('Transfert des images');
            $this->imageManager->moveImages($folder);

            // --------------  TRANSFERT DES DATA  -----------------------
            $io->title('Traitement du dossier');
            try {
                $this->transfertData($folder, $output, $io);
            } catch (Exception $e) {$io->error('Error load CSV file : ' . $e);}

            // --------------  TRANSFERT DES ARCHIVES  -----------------------
            $io->title('Création des archives');

            $this->archive($archive);
            $io->comment('Archives terminées');

            // --------------  SUPPRESSION DES ZIP  -----------------------
            $io->title('Suppresion du ZIP');
            if (preg_match('/([^\s]+(\.(?i)(zip))$)/i', $archive, $matches)) {
                $this->deleteZip($archive);
                $io->text('Suppression du Zip ' . $archive);
            }
            // --------------  SUPPRESSION DES EXTRACTS  -----------------------
            $io->title('Suppresion des dossiers Extracts');
            $folders = scandir($this->PATH_EXTRACT);
            foreach ($folders as $item) {
                if ($item != "." && $item != "..") {
                    $this->deleteFolder($this->PATH_EXTRACT . $item);
                    $io->text('Suppression du folder ' . $item);
                }
            }

            if($appel == 1){
                 // --------------  API IMMO JSON  -----------------------
                 $io->title("[APIMO JSON]");

                 $folder = 'agenadeguilles';
                 $ch = curl_init();
                 curl_setopt($ch, CURLOPT_URL, 'https://api.apimo.pro/agencies/'.getenv('APIMMO_AGENCY').'/properties');
                 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                 curl_setopt($ch, CURLOPT_USERPWD, getenv('APIMMO_PROVIDER') .':' . getenv('APIMMO_TOKEN'));
                 curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                 $outputJSON = curl_exec($ch);
                 curl_close($ch);
                 $values = json_decode($outputJSON, true);

                if($values){
                    $tabPathImg = [
                        'images' => $this->PATH_IMAGES,
                        'thumbs' => $this->PATH_THUMBS
                    ];
        
                    $this->traitement(self::ANNONCE_JSON, $io, $output, $folder, intval($values['total_items']), $values['properties'], $tabPathImg);
                }else{
                    $io->error('Aucune données pour APIMMO : ADE Immobiliere');
                }
            }

            $io->success('SUIVANT');
            $this->process(0, $io, $output);
        }

        return 1;
    }

    /**
     * Fonction permettant de supprimer les zip dans le dossier depot
     * @param $archive
     */
    protected function deleteZip($archive){
        if(file_exists($this->PATH_DEPOT . $archive)){
            unlink($this->PATH_DEPOT . $archive);
        }
    }

    protected function getDirname($item){
        $nameFolder = strtolower(substr($item,0, (strlen($item)-4)));
        $nameFolder = str_replace(" ", "_", $nameFolder);
        return $nameFolder;
    }

    protected function archive($archive){
        $pathArchive = $this->PATH_ARCHIVE;

        if(preg_match('/([^\s]+(\.(?i)(zip))$)/i', $archive, $matches)){

            $nameFolder = $this->getDirname($archive);
            $fileOri = $this->PATH_DEPOT . $archive;
            $fileOld1 =  $pathArchive . $nameFolder . '_1.zip';
            $fileOld2 =  $pathArchive . $nameFolder . '_2.zip';

            if(file_exists($fileOld2)){
                unlink($fileOld2);
                copy($fileOld1, $fileOld2);
                unlink($fileOld1);
            }

            if(file_exists($fileOld1)){
                copy($fileOld1, $fileOld2);
                unlink($fileOld1);
                copy($fileOri, $fileOld1);
            }else{
                copy($fileOri, $fileOld1);
            }
        }

    }

    /**
     * Delete folder
     * @param $folder
     */
    protected function deleteFolder($folder){
        if(is_dir($folder)){
            $clean = scandir($folder);

            foreach ($clean as $entry) {
                if ($entry != "." && $entry != "..") { unlink($folder . '/' . $entry); }
            }
            rmdir($folder);
        }
    }

    /**
     * Lance le traitement de du transfert de data
     * @param $type
     * @param SymfonyStyle $io
     * @param $output
     * @param $folder
     * @param $count
     * @param $records
     * @param $tabPathImg
     */
    protected function traitement($type, SymfonyStyle $io, $output, $folder, $count, $records, $tabPathImg){
        if ($count != 0) {
            $progressBar = new ProgressBar($output, $count);
            $progressBar->setFormat("%current%/%max% [%bar%] %percent:3s%%  🏁");
            $progressBar->setOverwrite(true);
            $progressBar->start();

            // Insertion des datas csv dans la DBB
            foreach ($records as $record) {
                $this->import->import($type, $folder, $record, $tabPathImg);
                $progressBar->advance();
            }

            $progressBar->finish();
            $io->text('------- Completed !');
            $reader = null;unset($reader);unset($records);
        } else {
            $io->warning("Aucune ligne contenu dans le fichier.");
        }
        $io->newLine(1);
    }

    /**
     * Transfert des data d'un folder
     * @param $folder
     * @param $output
     * @param SymfonyStyle $io
     * @throws \League\Csv\Exception
     */
    protected function transfertData($folder, $output, SymfonyStyle $io){
        $tabPathImg = [
            'images' => $this->PATH_IMAGES,
            'thumbs' => $this->PATH_THUMBS
        ];

        $io->comment('------- Dossier : ' . $folder);

        $file = $this->PATH_EXTRACT . $folder . '/' . $this->filenameData;
        $fileMaj = $this->PATH_EXTRACT . $folder . '/' . $this->filenameDataMaj;

        if (file_exists($file) || file_exists($fileMaj)) {
            $reader = file_exists($file) ? Reader::createFromPath($file) : Reader::createFromPath($fileMaj);
            $reader->setDelimiter('#');

            $records = $reader->getRecords(); // récupération de toutes les lignes
            $count = count($reader); // Nombre de records

            $this->traitement(self::ANNONCE_CSV, $io, $output, $folder, $count, $records, $tabPathImg);

        } else { // XML --- PERICLES
            $files = scandir($this->PATH_EXTRACT . $folder);
            $isFind = false;
            foreach ($files as $file) {
                if (preg_match('/([^\s]+(\.(?i)(xml))$)/i', $file, $matches)) {
                    $annonces = $file;
                    $isFind = true;
                }
            }

            if ($isFind) {
                $parseFile = simplexml_load_file($this->PATH_EXTRACT . $folder . "/" . $annonces, 'SimpleXMLElement', LIBXML_NOCDATA);
                $count = count($parseFile); // Nombre de records

                $this->traitement(self::ANNONCE_XML, $io, $output, $folder, $count, $parseFile, $tabPathImg);

            } else {
                $io->error('Aucun fichier annonce trouvé dans le dossier : ' . $folder);
            }
        }
    }

    /**
     * Reinitialise les tables à vides à partir d'une liste de nom d'entité
     * @param SymfonyStyle $io
     * @throws ConnectionException
     * @throws DBALException
     */
    protected function resetTable(SymfonyStyle $io){
        $agences = $this->em->getRepository(ShAgence::class)->findAll();
        $adresses = $this->em->getRepository(ShAdresse:: class)->findAll();
        $tabAdressesId = array();
        $toDelete = array();
        if($agences){
            foreach ($agences as $agence) {
                array_push($tabAdressesId, $agence->getAdresse()->getId());
            }
        }
        foreach ($adresses as $adress) {
            if(!in_array($adress->getId(), $tabAdressesId)){
                array_push($toDelete, $adress);
            }
        }
        foreach ($this->listEntity as $item) {
            $connection = $this->em->getConnection();

            $connection->beginTransaction();
            $connection->query('SET FOREIGN_KEY_CHECKS=0');
            $connection->executeUpdate(
                $connection->getDatabasePlatform()->getTruncateTableSQL(
                    $item, true
                )
            );
            $connection->query('SET FOREIGN_KEY_CHECKS=1');
            $connection->commit();
        }
        if(!empty($toDelete)){
            foreach ($toDelete as $item) {
                $this->em->remove($item);
                $this->em->flush();
            }
        }
        $io->comment('Reset [OK]');
    }

    /**
     * Create directory if not exist
     * @param array $directories
     */
    protected function createDir($directories){
        foreach ($directories as $directory) {
            if(!is_dir($directory)){
                mkdir($directory);
            }
        }
    }

    protected function getOriginalArchives($archives){
        $folders = array();
        foreach ($archives as $item) {
            if(preg_match('/([^\s]+(\.(?i)(zip))$)/i', $item, $matches)){
                array_push($folders, $item);
            }
        }
        return $folders;
    }

    /**
     * Fonction permettant de décompresser les zip dans le dossier extract
     * @param $archives
     * @param SymfonyStyle $io
     * @return array|string
     */
    protected function extractZIP($archives, SymfonyStyle $io){
        $isEmpty = true;
        $isOpen = false;
        $folders = array();
        foreach ($archives as $item) {
            $archive = new ZipArchive();
            if(preg_match('/([^\s]+(\.(?i)(zip))$)/i', $item, $matches)){
                $isEmpty = false;
                if($archive->open($this->PATH_DEPOT . $item) == true){
                    $nameFolder = $this->getDirname($item);
                    if($isOpen == false){
                        $archive->extractTo($this->PATH_EXTRACT . $nameFolder);
                        $archive->close(); unset($archive);
                        $io->comment("Archive " . $nameFolder . " [OK]");

                        array_push($folders, $nameFolder);
                        $isOpen = true;
                    }
                }else{
                    $io->error("Erreur archive");
                    return 0;
                }
            }
        }
        if($isEmpty){
            $io->comment("Aucun zip dans le dossier dépot.");
            return 0;
        }
        return $folders;
    }
}
