<?php

namespace App\Requests\Front;

use App\Core\FormRequest;
use App\Models\CommentReply;

class CommentReplyRequest extends FormRequest
{
    public function __construct()
    {
        parent::__construct($this->rules());
    }

    protected function rules(): array
    {
        return [
            'content' => 'required|string|min:3|max:100',
            'id_user' => 'required',
            'id_comment' => 'required'
        ];
    }

    protected function messages(): array
    {
        return [
            'content.required' => 'Le commentaire est requis.',
            'content.string' => 'Le commentaire doit être une chaîne de caractères.',
            'content.min' => 'Le commentaire doit comporter au minimum 3 caractères.',
            'content.max' => 'Le commentaire ne doit pas dépasser 100 caractères.',
            'id_user.required' => 'Une erreur est survenue.',
            'id_comment.required' => 'Une erreur est survenue.',
        ];
    }

    public function addCommentReply(): bool
    {
        $validatedData = $this->validate();

        if (!$validatedData) {
            return false;
        }

        $commentReply = new CommentReply();
        $commentReply->setIdcomment($validatedData['id_comment']);
        $commentReply->setIdUser($validatedData['id_user']);
        $commentReply->setContent($validatedData['content']);
        $commentReply->setIdStatus(ID_COMMENT_STATUS_NON_TRAITE);
        $commentReply->setCreatedAt(date("Y-m-d H:i:s"));
        $commentReply->setUpdatedAt(date("Y-m-d H:i:s"));
        $commentReply->create();

        return true;
    }
}