<?php

namespace App\Controllers\Front;

use App\Controllers\Controller;
use App\Core\QueryBuilder;
use App\Core\View;
use App\Models\Message;
use App\Models\CategorieMessage;
use App\Requests\MessageRequest;


class MessageController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function createAction(): void
    {
        $categories = CategorieMessage::all();

        view('message/front/create', 'front', [
            'categories' => $categories
        ]);
    }

    public function storeAction(): void
    {
        $request = new MessageRequest();
        $categories = CategorieMessage::all();

        if (!$request->createMessage()) {
            view('message/front/create', 'front', [
                'categories' => $categories,
                'errors' => $request->getErrors(),
                'old'    => $request->getOld()
            ]);
        }

        $_SESSION['success_message'] = "Votre message a été envoyé avec succès.";
        $this->redirectToContactPage();
    }

    private function redirectToContactPage(): void
    {
        header('Location: /message');
        exit();
    }
}
