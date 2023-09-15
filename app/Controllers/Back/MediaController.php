<?php

namespace App\Controllers\Back;

use App\Controllers\Controller;
use App\Core\QueryBuilder;
use App\Models\Media;
use App\Requests\MediaRequest;

class MediaController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function listAction(): void
    {
        $medias = Media::all();

        $scripts = [
            '/js/media/list.js',
            '/js/datatables/datatables.min.js',
            '/js/datatables/index.js',
            '/js/datatables/media-list.js',
        ];
        
        foreach ($medias as $media) {
            $media->src = $this->generateMediaArray($media);
        }

        view('media/back/list', 'back', [
            'medias' => $medias
        ], $scripts);
    }

    public function createAction(): void
    {
        $medias = Media::all();

        view('media/back/create', 'back', [
            'medias' => $medias
        ]);
    }

    public function storeAction(): void
    {
        $request = new MediaRequest();

        if (!$request->createMedia()) {
            view('media/back/create', 'back', [
                'file'   => isset($_FILES['file']),
                'medias' => Media::all(),
                'errors' => $request->getErrors(),
                'old'    => $request->getOld(),
            ]);
        }

        $this->redirectToList();
    }

    public function showAction($id): void
    {
        $media = Media::find($id);

        if (!$media)
            $this->redirectToList();

        view('media/back/show', 'back', [
            'media' => $media,
        ]);
    }

    public function editAction($id): void
    {
        $media = Media::find($id);

        $mediaSlug = preg_replace('/^\/\d{4}\/\d{2}\/\d{2}\//', '/', $media->getSlug());
        $extension = pathinfo($mediaSlug, PATHINFO_EXTENSION); // Obtenir l'extension du fichier
        $mediaSlug = rtrim($mediaSlug, '.' . $extension); // Retirer l'extension du chemin
                
        if (!$media)
            $this->redirectToList();

        view('media/back/edit', 'back', [
            'media' => $media,
            'mediaSlug' => $mediaSlug
        ]);
    }

    public function deleteAction($id): void
    {
        $media = Media::find($id);

        if ($media) {
            $media->delete();
        }

        $this->redirectToList();
    }

    public function updateAction($id): void
    {
        $media = Media::find($id);

        if (!$media) {
            $this->redirectToList();
        }

        $request = new MediaRequest();

        if (!$request->updateMedia($media)) {
            view('media/back/edit', 'back', [
                'media' => $media,
                'errors'    => $request->getErrors(),
                'old'       => $request->getOld()
            ]);
        }

        $this->redirectToList();
    }

    private function redirectToList(): void
    {
        header('Location: /admin/media/list');
        exit();
    }

    private function generateMediaArray($media) {
        switch ($media->type) {
            case 'pdf':
                $html = '<a href="' . SITE_URL . '/uploads' . $media->slug . '" target="_blank" class="d-block">';
                $html .= '<embed src="' . SITE_URL . '/uploads' . $media->slug . '" width="50" height="70" type="application/pdf">';
                $html .= '</a>';
                break;
            case 'mp4':
                $html = '<video width="7rem" height="3rem" controls>';
                $html .= '<source src="' . SITE_URL . '/uploads' . $media->slug . '" type="video/mp4">';
                $html .= 'Your browser does not support the video tag.';
                $html .= '</video>';
                break;
            default:
                $html = '<a href="' . SITE_URL . '/uploads' . $media->slug . '" target="_blank" class="d-block">';
                $html .= '<img src="' . SITE_URL . '/uploads' . $media->slug . '" class="w-100 h-100">';
                $html .= '</a>';
                break;
        }
        return $html;
    }

}
