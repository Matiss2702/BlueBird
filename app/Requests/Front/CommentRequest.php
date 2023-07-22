<?php

namespace App\Requests\Front;

use App\Core\FormRequest;
use App\Models\Comment;

class CommentRequest extends FormRequest
{
    public function __construct()
    {
        parent::__construct($this->rules());
    }

    protected function rules(): array
    {
        return [
            'content' => 'required|string|min:3|max:100',
            'entity' => 'required|string',
            'id_entity' => 'required',
            'id_user' => 'required',
        ];
    }

    protected function messages(): array
    {
        return [
            'content.required' => 'Le commentaire est requis.',
            'content.string' => 'Le commentaire doit être une chaîne de caractères.',
            'content.max' => 'Le commentaire ne doit pas dépasser 100 caractères.',
            'entity.required' => 'Une erreur est survenue.',
            'entity.string' => 'Une erreur est survenue.',
            'id_user.required' => 'Une erreur est survenue.',
            'id_comment.required' => 'Une erreur est survenue.',
        ];
    }

    public function addComment(): bool
    {
        $validatedData = $this->validate();

        if (!$validatedData) {
            return false;
        }

        $comment = new Comment();
        $comment->setContent($validatedData['content']);
        $comment->setEntity($validatedData['entity']);
        $comment->setIdEntity($validatedData['id_entity']);
        $comment->setIdUser($validatedData['id_user']);
        $comment->setIdStatus(ID_COMMENT_STATUS_NON_TRAITE);
        $comment->setCreatedAt(date("Y-m-d H:i:s"));
        $comment->setUpdatedAt(date("Y-m-d H:i:s"));
        $comment->create();

        return true;
    }
}