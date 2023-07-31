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
            'slug' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'content' => 'required|string',
        ];
    }

    protected function messages(): array
    {
        return [
            'title.required' => 'Le titre est requis.',
            'title.string' => 'Le titre doit être une chaîne de caractères.',
            'title.max' => 'Le titre ne doit pas dépasser 255 caractères.',
            'slug.required' => 'Le slug est requis.',
            'slug.string' => 'Le slug doit être une chaîne de caractères.',
            'slug.max' => 'Le slug ne doit pas dépasser 255 caractères.',
            'description.required' => 'La description est requise.',
            'description.string' => 'La description de la page doit être une chaîne de caractères.',
            'description.max' => 'La description de la page ne doit pas dépasser 255 caractères.',
            'content.required' => 'Le contenu de la page est requis.',
            'content.string' => 'Le contenu de la page doit être une chaîne de caractères.',
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
        $page->setSlug($validatedData['slug']);
        $page->setDescription($validatedData['description']);
        $page->setContent($validatedData['content']);
        $page->setCreatedAt(date('Y-m-d H:i:s'));
        $page->setUpdatedAt(date('Y-m-d H:i:s'));
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
        $page->setSlug($validatedData['slug']);
        $page->setDescription($validatedData['description']);
        $page->setContent($validatedData['content']);
        $page->setUpdatedAt(date('Y-m-d H:i:s'));
        $page->update();

        return true;
    }
}
