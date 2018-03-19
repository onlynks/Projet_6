<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 23/02/2018
 * Time: 16:42
 */

namespace P6\PlatformBundle\Service;


use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class FileUploader
{
    private $targetDir;

    public function __construct($targetDir)
    {
        $this->targetDir = $targetDir;
    }

    public function upload(UploadedFile $file)
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        $file->move($this->getTargetDir(), $fileName);

        return $fileName;
    }

    public function multiUpload(ArrayCollection $files)
    {
        foreach($files as $file)
        {
            $this->upload($file->getFile());
        }

    }

    /**
     * @return mixed
     */
    public function getTargetDir()
    {
        return $this->targetDir;
    }
}

