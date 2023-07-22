<?php

namespace App\Controllers\Back;

use App\Controllers\Controller;
use App\Core\UploadedFile;
use App\Models\TemplateOne;
use App\Requests\TemplateOneRequest;

class PageController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function listAction(): void
    {
        view('template-one/back/list', 'back', [
            'pages' => TemplateOne::all()
        ]);
    }

    public function createAction(): void
    {
        view('template-one/back/create', 'back');
    }

    public function storeAction(): void
    {
        $request = new TemplateOneRequest();

        $imageFields = ['about_img', 'main_bloc_img', 'bloc_one_img', 'bloc_two_img'];
        $uploadedFiles = [];
        foreach ($imageFields as $fieldName) {
            if (isset($_FILES[$fieldName]) && $_FILES[$fieldName]['error'] === UPLOAD_ERR_OK) {
                $uploadedFile = new UploadedFile($_FILES[$fieldName]);

                $allowedExtensions = ['png', 'jpg', 'jpeg'];
                $fileExtension = pathinfo($uploadedFile->getName(), PATHINFO_EXTENSION);

                if (in_array(strtolower($fileExtension), $allowedExtensions)) {
                    $uniqueFileName = uniqid() . '.' . $fileExtension;
                    $uploadPath = __DIR__ . '/../../../public/resources/uploads/template-one/' . $uniqueFileName;

                    if (move_uploaded_file($uploadedFile->getTmpName(), $uploadPath)) {
                        $request->editPostRequest($fieldName, $uniqueFileName);
                        $uploadedFiles[$fieldName] = $uploadPath;
                    } else {
                        $request->addError($fieldName, 'Une erreur est survenue lors de l\'enregistrement.');
                        return;
                    }
                } else {
                    $request->addError($fieldName, 'Une erreur est survenue lors de l\'enregistrement.');
                    return;
                }
            }
        }

        if (!$request->createTemplateOne()) {
            view('template-one/back/create', 'back', [
                'errors' => $request->getErrors(),
                'old'    => $request->getOld(),
            ]);
            return;
        }

        $this->redirectToList();
    }

    public function showAction($id): void
    {
        $page = TemplateOne::find($id);

        if (!$page)
            $this->redirectToList();

        view('template-one/back/show', 'back', [
            'page' => $page
        ]);
    }

    public function editAction($id): void
    {
        $page = TemplateOne::find($id);

        if (!$page)
            $this->redirectToList();

        view('template-one/back/edit', 'back', [
            'page' => $page
        ]);
    }

    public function updateAction($id): void
    {
        $page = TemplateOne::find($id);

        if (!$page) {
            $this->redirectToList();
        }

        $request = new TemplateOneRequest();

        if (!$request->updateTemplateOne($page)) {
            view('template-one/back/edit', 'back', [
                'page'   => $page,
                'errors' => $request->getErrors(),
                'old'    => $request->getOld()
            ]);
        }

        $this->redirectToList();
    }

    public function deleteAction($id): void
    {
        $page = TemplateOne::find($id);

        if ($page) {
            $page->delete();
        }

        $this->redirectToList();
    }

    private function redirectToList(): void
    {
        header('Location: /admin/page/list');
        exit();
    }
}
