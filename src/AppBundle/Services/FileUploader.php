<?php

namespace AppBundle\Services;


use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader{

    private $targetDir;
    public function __construct($targetDir)
    {
        $this->targetDir = $targetDir;
    }

    public function upload(UploadedFile $uploadedFile)
    {
        $fileName = uniqid() . '.' . $uploadedFile->guessExtension();
        $uploadedFile->move($this->targetDir, $fileName);

        return $fileName;
    }
}