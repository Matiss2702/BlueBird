<?php

namespace App\Controllers\Back;

use App\Controllers\Controller;
use App\Core\QueryBuilder;
use App\Core\View;
use \App\Models\Message;
use \App\Models\CategorieMessage;
use App\Requests\MessageRequest;


class MessageController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function listAction(): void
    {
        $scripts =  [
            '/js/datatables/datatables.min.js',
            '/js/datatables/index.js',
            '/js/datatables/message-list.js',
        ];

        view('message/back/list', 'back', [
            'messages' => Message::all()
        ], $scripts);
    }

    public function createAction(): void
    {
        $categories = CategorieMessage::all();

        view('message/back/create', 'back', [
            'categories' => $categories
        ]);
    }

    public function storeAction(): void
    {
        $request = new MessageRequest();

        if (!$request->createMessage()) {
            view('message/back/create', 'back', [
                'categories' => CategorieMessage::all(),
                'errors' => $request->getErrors(),
                'old'    => $request->getOld()
            ]);
        }

        $this->redirectToList();
    }

    public function showAction($id): void
    {
        $message = QueryBuilder::table('message')
            ->select(
                'message.*',
                'categorie_message.description',
            )
            ->join('categorie_message', function($join) {
                $join->on('categorie_message.id', '=', 'message.id_categorie_message');
            })
            ->where('message.id', $id)
            ->first();

        if (!$message)
            $this->redirectToList();

        view('message/back/show', 'back', [
            'message' => $message
        ]);
    }

    public function editAction($id): void
    {
        $categories = CategorieMessage::all();
        $message = Message::find($id);

        if (!$message)
            $this->redirectToList();

        view('message/back/edit', 'back', [
            'message' => $message,
            'categories'   => $categories
        ]);
    }

    public function deleteAction($id): void
    {
        $message = Message::find($id);

        if ($message) {
            $message->delete();
        }

        $this->redirectToList();
    }

    public function updateAction($id): void
    {
        $categories = CategorieMessage::all();
        $message = Message::find($id);

        if (!$message) {
            $this->redirectToList();
        }

        $request = new MessageRequest();

        if (!$request->updateMessage($message)) {
            view('message/back/edit', 'back', [
                'message' => $message,
                'categories'   => $categories,
                'errors'    => $request->getErrors(),
                'old'       => $request->getOld()
            ]);
        }

        $this->redirectToList();
    }

    private function redirectToList(): void
    {
        header('Location: /admin/message/list');
        exit();
    }
}
