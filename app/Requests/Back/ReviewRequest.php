<?php

namespace App\Requests\Back;

use App\Models\Review;
use App\Core\FormRequest;

class ReviewRequest extends FormRequest
{
    public function __construct()
    {
        parent::__construct($this->rules());
    }

    protected function rules(): array
    {
        return [
            'rate' => 'required|integer|min:0|max:5',
            'comment' => 'required|string|max:3000',
            'id_movie' => 'required|integer',
            'id_user' => 'required|integer',
        ];
    }

    protected function messages(): array
    {
        return [
            'rate.required' => 'Le champ note est requis',
            'rate.integer' => 'Le champ note doit être un entier',
            'rate.min' => 'Le champ note doit être compris entre 0 et 5',
            'rate.max' => 'Le champ note doit être compris entre 0 et 5',

            'comment.required' => 'Le champ commentaire est requis',
            'comment.string' => 'Le champ commentaire doit être une chaîne de caractères',
            'comment.max' => 'Le champ commentaire ne doit pas dépasser 3000 caractères',

            'id_movie.required' => 'Le champ film est requis',
            'id_movie.integer' => 'Le champ film doit être un entier',

            'id_user.required' => 'Le champ utilisateur est requis',
            'id_user.integer' => 'Le champ utilisateur doit être un entier',
        ];
    }

    public function createReview(): bool
    {
        $validatedData = $this->validate();

        if (!$validatedData) {
            return false;
        }

        $review = new Review();
        $review->setRate($validatedData['rate']);
        $review->setComment($validatedData['comment']);
        $review->setIdMovie($validatedData['id_movie']);
        $review->setIdUser($validatedData['id_user']);
        $review->create();

        return true;
    }

    public function updateReview($review): bool
    {
        $validatedData = $this->validate();

        if (!$validatedData) {
            return false;
        }

        if (!$review instanceof Review) {
            $review = Review::find($review['id_review']);
        }

        $review->setRate($validatedData['rate']);
        $review->setComment($validatedData['comment']);
        $review->setIdMovie($validatedData['id_movie']);
        $review->setIdUser($validatedData['id_user']);
        $review->update();

        return true;
    }
}