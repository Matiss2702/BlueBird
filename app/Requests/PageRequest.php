<?php

namespace App\Requests;

use App\Core\FormRequest;
use App\Models\Page;

class PageRequest extends FormRequest
{
    public function __construct()
    {
        parent::__construct($this->rules());
    }

    protected function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ];
    }

    protected function messages(): array
    {
        return [
            'title.required' => 'Le champ titre est requis.',
            'title.string' => 'Le champ titre doit être une chaîne de caractères.',
            'title.max' => 'Le champ titre ne doit pas dépasser 255 caractères.',
            'content.required' => 'Le champ contenu est requis.',
            'content.string' => 'Le champ contenu doit être une chaîne de caractères.',
        ];
    }

    public function createPage(): bool
    {
        $validatedData = $this->validate();

        if (!$validatedData) {
            return false;
        }

        $page = new Page();
        $page->setTitle($validatedData['title']);
        $page->setContent($validatedData['content']);
        $page->create();

        return true;
    }

    public function updatePage($page): bool
    {
        $validatedData = $this->validate();

        if (!$validatedData) {
            return false;
        }

        $page->setTitle($validatedData['title']);
        $page->setContent($validatedData['content']);
        $page->update();

        return true;
    }
}
