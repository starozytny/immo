<?php

namespace Shanbo\ImmobilierBundle\Manager\Import\Data;


use Shanbo\ImmobilierBundle\Manager\Import\DataSanitize;

class DataImage extends DataSanitize
{

    protected $images;

    public function __construct($type, $data, $folder, $tabPathImg)
    {
        $this->pathImg = $tabPathImg['images'];
        $this->pathThumbs = $tabPathImg['thumbs'];
        $this->folder = $folder;

        if($type == 0){
            $this->images = [
                new ImageToFile($data[84], $tabPathImg, $folder),
                new ImageToFile($data[85], $tabPathImg, $folder),
                new ImageToFile($data[86], $tabPathImg, $folder),
                new ImageToFile($data[87], $tabPathImg, $folder),
                new ImageToFile($data[88], $tabPathImg, $folder),
                new ImageToFile($data[89], $tabPathImg, $folder),
                new ImageToFile($data[90], $tabPathImg, $folder),
                new ImageToFile($data[91], $tabPathImg, $folder),
                new ImageToFile($data[92], $tabPathImg, $folder)
            ];
        }else{
            $nameImg = $data->CODE_SOCIETE . "-" . $data->CODE_SITE . "-" . $data->NO_ASP;
            $this->images = [
                new ImageToFile($nameImg . "-a.jpg", $tabPathImg, $folder),
                new ImageToFile($nameImg . "-b.jpg", $tabPathImg, $folder),
                new ImageToFile($nameImg . "-c.jpg", $tabPathImg, $folder),
                new ImageToFile($nameImg . "-d.jpg", $tabPathImg, $folder),
                new ImageToFile($nameImg . "-e.jpg", $tabPathImg, $folder),
                new ImageToFile($nameImg . "-f.jpg", $tabPathImg, $folder),
                new ImageToFile($nameImg . "-g.jpg", $tabPathImg, $folder),
                new ImageToFile($nameImg . "-h.jpg", $tabPathImg, $folder),
                new ImageToFile($nameImg . "-i.jpg", $tabPathImg, $folder),
                new ImageToFile($nameImg . "-j.jpg", $tabPathImg, $folder)
            ];
        }
    }

    /**
     * @return array
     */
    public function getImages(): array
    {
        return $this->images;
    }

    /**
     * @param array $images
     */
    public function setImages(array $images): void
    {
        $this->images = $images;
    }

}
