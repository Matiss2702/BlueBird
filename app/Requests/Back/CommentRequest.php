<?php

namespace App\Requests\Back;

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
            'id_status' => 'required',
        ];
    }

    protected function messages(): array
    {
        return [
            'content.required' => 'Le commentaire est requis.',
            'content.string' => 'Le commentaire doit être une chaîne de caractères.',
            'content.max' => 'Le commentaire ne doit pas dépasser 100 caractères.',
            'id_status.required' => 'Le statut est requis.',
        ];
    }

    public function updateComment($comment): bool
    {
        $validatedData = $this->validate();

        if (!$validatedData) {
            return false;
        }

        if (!$comment instanceof Comment) {
            $comment = Comment::find($comment['id']);
        }

        $comment->setContent($validatedData['content']);
        $comment->setIdStatus($validatedData['id_status']);
        $comment->setUpdatedAt(date("Y-m-d H:i:s"));
        $comment->update();

        return true;
    }
}