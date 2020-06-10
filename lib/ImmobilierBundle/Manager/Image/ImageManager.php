<?php

namespace Shanbo\ImmobilierBundle\Manager\Image;


use Exception;
use Symfony\Component\Console\Style\SymfonyStyle;

class ImageManager
{
    protected $path_extract;
    protected $path_img;
    protected $path_thumb;
    protected $io;
    /**
     * Create directory if not exist
     * @param $pathdir
     */
    protected function createDir($pathdir){
        if(!is_dir($pathdir)){
            mkdir($pathdir);
        }
    }

    /**
     * Fonction permettant de déplacer les images vers le dossier public/annonces/images
     * @param $folder
     * @param int $tailleW
     * @param int $tailleH
     */
    public function moveImages($folder, $tailleW = 150, $tailleH = 150){
        $io = $this->getIo();
        $config = ['Mode' => 'FULL'];
        $pathSrcFolder = $this->path_extract . $folder;
        $dir = scandir($pathSrcFolder);

        // ------------------------ CONFIGURATION PHOTO
        $findConfig = false;
        foreach ($dir as $file) {
            if (preg_match('/([^\s]+(\.(?i)(cfg))$)/i', $file, $matches)) {
                $config = parse_ini_file($pathSrcFolder . '/' . $file);
                $findConfig = true;
            }
        }

        $io->comment('Config Photo : ' . $folder);
        $isEmpty = true;

        if (!$findConfig) {
//            $io->text('### - WARNING - ### Fichier de config photo introuvable.');
//            $io->text('### - WARNING - ### Config set default FULL');
            $io->text('Fichier config introuvable -> set to default FULL MODE');
        }

        // ------------------------ INITIALISATION DES DOSSIERS DE DESTINATION
        $pathImgWithFolder = $this->path_img . $folder;
        $this->createDir($pathImgWithFolder);
        $this->createDir($this->path_thumb . $folder);

        // ------------------------- ACTION SUR IMG EN FONCTION DE LA CONFIG
        ini_set('gd.jpeg_ignore_warning', true);
        switch ($config['Mode']) {
            case "FULL":
                $io->text("[Photos en mode FULL]");
                foreach ($dir as $item) {
                    if (preg_match('/([^\s]+(\.(?i)(JPG|GIF|PNG|JPEG|jpg|gif|png))$)/i', $item, $matches)) {
                        $isEmpty = false;
                        $this->moveAction($folder, $pathSrcFolder, $pathImgWithFolder, $item,  $tailleW, $tailleH);
                    }
                }
                break;
            case "URL":
                $io->text("[Photos en mode URL]");
                $isEmpty = false;
                break;
            default:
                $io->error("Photos en mode DIFF");
                break;
        }


        if ($isEmpty) {
            $io->comment("Dossier " . $folder . " vide ou fichiers non conforme ou config erroné.");
        } else {
            $io->text("--------- Fin transfert.");
        }
        unset($dir);

        $io->newLine(1);
    }

    /**
     * Function appellant la création de thumb et déplacement des images dans le dossier spécifié
     * @param $folder
     * @param $pathSrcFolder
     * @param $pathImgWithFolder
     * @param $item
     * @param $tailleW
     * @param $tailleH
     */
    protected function moveAction($folder, $pathSrcFolder, $pathImgWithFolder, $item,  $tailleW, $tailleH){
        $io = $this->getIo();
        $this->createThumb($pathSrcFolder . "/" . $item, $item, $folder, $this->path_extract,  $tailleW, $tailleH);

        // déplacement des images
        if (rename(
            $pathSrcFolder . "/" . $item,
            $pathImgWithFolder . "/" . $item
        )) {
        } else {
            $io->warning("L'image : " . $item . " n'a pas été déplacé.");
        }
    }

    /**
     * Resize and create l'image en thumbs
     * @param $file
     * @param $item
     * @param $folder
     * @param $srcPath
     * @param $tailleW
     * @param $tailleH
     */
    public function createThumb($file, $item, $folder, $srcPath, $tailleW, $tailleH) {
        list($width, $height) = getimagesize($file);

        $ratio_orig = $width/$height;
        $w = $tailleW;
        $h = $tailleH;


        if ($w/$h > $ratio_orig) {
            $w = $h*$ratio_orig;
        } else {
            $h = $w/$ratio_orig;
        }

        ini_set('gd.jpeg_ignore_warning', true);
        $src = @imagecreatefromjpeg($file);
        $thumb = imagecreatetruecolor($w, $h);
        @imagecopyresampled($thumb, $src, 0, 0, 0, 0, $w, $h, $width, $height);

        $nameWithoutExt = pathinfo($srcPath . $folder . '/' .$item)['filename'];
        $name = $nameWithoutExt . '-thumbs.jpg';

        @imagejpeg($thumb, $this->path_thumb . $folder . "/" . $name,75);
    }

    /**
     * Download et déplace l'image via une URL
     * @param $file
     * @param $folder
     * @return bool|string
     */
    public function downloadImgURL($file, $folder){
        try{
            if(!is_dir($this->path_img . $folder)){
                mkdir($this->path_img . $folder);
            }
            if(!is_dir($this->path_thumb . $folder)){
                mkdir($this->path_thumb . $folder);
            }
            $current = file_get_contents($file);
            $filename = substr($file, strripos($file, "/")+1 , strlen($file));
            $file = $this->path_img . $folder . '/' .$filename;
            file_put_contents($file, $current);
        }catch (Exception $e){
            return  null;
        }

        return $filename;
    }

    public function setPathExtract(string $path_extract): void
    {
        $this->path_extract = $path_extract;
    }

    public function setPathImg(string $path_img): void
    {
        $this->path_img = $path_img;
    }

    public function setPathThumb(string $path_thumb): void
    {
        $this->path_thumb = $path_thumb;
    }


    public function getIo(): SymfonyStyle
    {
        return $this->io;
    }

    public function setIo(SymfonyStyle $io): void
    {
        $this->io = $io;
    }
}
