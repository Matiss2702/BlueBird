<?php

namespace App\Requests;

use App\Models\CategoryMovie;
use App\Core\FormRequest;

class CategoryMovieRequest extends FormRequest
{
    public function __construct()
    {
        parent::__construct($this->rules());
    }

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:200',
        ];
    }

    protected function messages(): array
    {
        return [
            'name.required' => 'Le nom est requis.',
            'name.string' => 'Le nom doit être une chaîne de caractères.',
            'name.max' => 'Le nom ne doit pas dépasser 200 caractères.',
        ];
    }

    public function createCategoryMovie(): bool
    {
        $validatedData = $this->validate();

        if (!$validatedData) {
            return false;
        }

        $categoryMovie = new CategoryMovie();
        $categoryMovie->setName($validatedData['name']);
        $categoryMovie->setUpdatedAt(date('Y-m-d H:i:s'));
        $categoryMovie->create();

        return true;
    }

    public function updateCategoryMovie($categoryMovie): bool
    {
        $validatedData = $this->validate();

        if (!$validatedData) {
            return false;
        }

        if (!$categoryMovie instanceof CategoryMovie) {
            $categoryMovie = CategoryMovie::find($categoryMovie['id']);
        }

        $categoryMovie->setName($validatedData['name']);
        $categoryMovie->setUpdatedAt(date("Y-m-d H:i:s"));
        $categoryMovie->update();

        return true;
    }
}