<?php

namespace App\Requests;

use App\Models\Media;
use App\Core\QueryBuilder;
use App\Core\FormRequest;

class MediaRequest extends FormRequest
{
    public function __construct()
    {
        parent::__construct($this->rules());
    }

    protected function rules(): array
    {
        return [
            'file' => 'file-type:png:jpg:jpeg:pdf:mp4|file-size:134217728',
            'name' => 'string|min:0|max:255',
            'slug' => 'string|min:0|max:500',
            'alt' => 'string|min:0|max:255',
        ];
    }

    protected function messages(): array
    {
        return [
            'file.file-type' => 'Le champ file n\'inclus pas votre fichier !',
            'file.file-size' => 'Votre fichier est trop lourd',

            'name.required' => 'Le nom est requis',
            'name.string' => 'Le nom doit être une chaine de charactère',
            'name.min' => 'Le nom doit être compris entre 0 et 255',
            'name.max' => 'Le nom doit être compris entre 0 et 255',

            'slug.string' => 'Le champ slug doit être une chaîne de caractères',
            'slug.max' => 'Le champ alt ne doit pas dépasser 500 caractères',

            'alt.string' => 'Le champ alt doit être une chaîne de caractères',
            'alt.max' => 'Le champ alt ne doit pas dépasser 255 caractères',
        ];
    }

    public function createMedia(): bool
    {
        $validatedData = $this->validate();

        if (!$validatedData) {
            return false;
        }

        $slug = $validatedData['slug'];
        $checkSlug = QueryBuilder::table('media')
        ->select(['slug'])
        ->where('slug', 'like', '%'.$slug.'%')
        ->get();

        $countSlug = count($checkSlug);

        if ($countSlug > 0) {
            $countSlug = $countSlug+1;
            $slug = $slug.'-'.$countSlug;
        }

        if (strpos($slug, '/') !== 0) {
            $slug = '/'.$slug;
            $slug = strtolower($slug);
        }

        $file = $_FILES['file'];

        $fileNameDef = $slug;
        $fileType = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        $currentDate = date('Y/m/d');
        $slugDef = '/'.$currentDate.$slug.'.'.$fileType;
        $media = new Media();
        $media->setName($validatedData['name']);
        $media->setAlt($validatedData['alt']);
        $media->setSlug($slugDef);
        $media->setType($fileType);
        $media->setCreatedAt(date('Y-m-d H:i:s'));
        $media->setUpdatedAt(date('Y-m-d H:i:s'));
        $this->checkFile($file, $fileNameDef, $fileType);
        $media->create();
        return true;
    }

    public function updateMedia($media): bool
    {
        $validatedData = $this->validate();

        if (!$validatedData) {
            return false;
        }

        if (!$media instanceof Media) {
            $media = Media::find($media['id']);
        }

        $slug = $validatedData['slug'];
        
        $mediaId = $media->getId();  

        $file = $_FILES['file'];
        
        $fileNameDef = $slug;
        $fileType = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        $currentDate = date('Y/m/d');
        $slugDef = '/'.$currentDate.$slug.'.'.$fileType;

        $media->setName($validatedData['name']);
        $media->setAlt($validatedData['alt']);
        $media->setSlug($slugDef);
        $media->setType($fileType);
        $media->setUpdatedAt(date('Y-m-d H:i:s'));

        $this->checkFile($file, $fileNameDef, $fileType);
        $media->update();

        return true;
    }

    public function checkFile($file, $fileNameDef, $fileType): bool
    {
        $uploadDir = '../public/uploads/';
        $currentDate = date('Y/m/d');
        $fullUploadDir = $uploadDir . $currentDate . '/';
        if (!file_exists($fullUploadDir)) {
            mkdir($fullUploadDir, 0777, true);
        }
        
        $fileNameDef = ltrim($fileNameDef, '/');

        $fullFilePath  = $fullUploadDir . $fileNameDef .'.'.$fileType;

        if (move_uploaded_file($file['tmp_name'], $fullFilePath)) {
            return true;
        }

        return false;
    }
}