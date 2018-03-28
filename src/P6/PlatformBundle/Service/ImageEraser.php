<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 21/03/2018
 * Time: 19:23
 */

namespace P6\PlatformBundle\Service;


class ImageEraser
{
    private $targetDir;


    public function __construct($targetDir)
    {
        $this->targetDir = $targetDir;
    }

    public function delete($files)
    {
        foreach($files as $file)
        {
            unlink($this->targetDir.'/'.$file);
        }

    }
}