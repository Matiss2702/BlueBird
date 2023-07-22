<?php

namespace App\Core;

class UploadedFile
{
    private $name;
    private $type;
    private $tmpName;
    private $error;
    private $size;

    public function __construct(array $fileData)
    {
        $this->name = $fileData['name'] ?? null;
        $this->type = $fileData['type'] ?? null;
        $this->tmpName = $fileData['tmp_name'] ?? null;
        $this->error = $fileData['error'] ?? 1;
        $this->size = $fileData['size'] ?? 0;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getTmpName()
    {
        return $this->tmpName;
    }

    public function getError()
    {
        return $this->error;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function getClientMimeType()
    {
        return $this->type;
    }
}
