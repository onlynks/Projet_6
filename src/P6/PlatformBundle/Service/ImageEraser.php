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
        if(is_array($files))
        {
            foreach($files as $file)
            {
                if(file_exists($file))
                {
                    unlink($this->targetDir.'/'.$file);
                }
            }
        }
        else
        {
            unlink($this->targetDir.'/'.$files);
        }


    }
}