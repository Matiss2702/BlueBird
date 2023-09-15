<?php

namespace App\Requests;

use App\Core\FormRequest;

class WebInfoSetupRequest extends FormRequest
{
    public function __construct()
    {
        parent::__construct($this->rules());
    }

    protected function rules(): array
    {
        return [
            'title' => 'required|string|min:3|max:30',
            'description' => 'required|string|min:3|max:255',
        ];
    }

    protected function messages(): array
    {
        return [
            'title.required' => 'Le titre du site est requis.',
            'title.string' => 'Le titre du site doit être une chaîne de caractères.',
            'title.max' => 'Le titre du site ne doit pas dépasser 30 caractères.',
            'title.min' => 'Le titre du site doit contenir au moins 3 caractères.',
            'description.required' => 'La description est requis.',
            'description.string' => 'La description doit être une chaîne de caractères.',
            'description.max' => 'La description ne doit pas dépasser 255 caractères.',
        ];
    }

    public function setWebInfo(): bool
    {
        $validatedData = $this->validate();
        if (!$validatedData) {
            return false;
        }

        return true;
    }
}
