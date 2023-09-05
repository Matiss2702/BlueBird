<?php

namespace App\Requests;

use App\Core\FormRequest;
use App\Core\QueryBuilder;
use App\Models\Page;
use App\Models\Memento;

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
            'description' => 'required|string|max:60',
            'content' => 'required|string',
        ];
    }

    protected function messages(): array
    {
        return [
            'title.required' => 'Le champ titre est requis.',
            'title.string' => 'Le champ titre doit être une chaîne de caractères.',
            'title.max' => 'Le champ titre ne doit pas dépasser 255 caractères.',
            'slug.required' => 'Le champ titre est requis.',
            'slug.string' => 'Le champ titre doit être une chaîne de caractères.',
            'slug.max' => 'Le champ titre ne doit pas dépasser 255 caractères.',
            'description.required' => 'Le champ titre est requis.',
            'description.string' => 'Le champ titre doit être une chaîne de caractères.',
            'description.max' => 'Le champ titre ne doit pas dépasser 60 caractères.',
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

        $slug = $validatedData['slug'];

        if (substr($slug, 0, 1) !== '/') {
            $slug = '/' . $slug;
        }        

        if (substr_count($slug, '/') >= 2) {
            $error = 'Veuillez Recommencer';
            return $error;
        }

        $checkSlug = QueryBuilder::table('page')
        ->select('COUNT(slug)')
        ->where('slug', '=', '%'.$slug.'%')
        ->get();

        $count = count($checkSlug);

        $page = new Page();
        $page->setTitle($validatedData['title']);
        if ($checkSlug) {
            $count = count($checkSlug);
            $slug = $slug.'-'.$count;
            $page->setSlug($slug);
        } else {
            $page->setSlug($validatedData['slug']);
        }
        $page->setDescription($validatedData['description']);
        $page->setContent($validatedData['content']);
        $page->setCreatedAt(date('Y-m-d H:i:s'));
        $page->setUpdatedAt(date('Y-m-d H:i:s'));
        $pageId = $page->create();
        $page = Page::find($pageId);

        $memento = new Memento();
        $memento->setTitle($validatedData['title']);
        $memento->setSlug($page->getSlug());
        $memento->setDescription($validatedData['description']);
        $memento->setContent($validatedData['content']);
        $memento->setCreatedAt(date('Y-m-d H:i:s'));
        $memento->setIdPage($page->getId());
        $memento->create();

        return true;
    }

    public function updatePage($page): bool
    {
        $validatedData = $this->validate();

        if (!$validatedData) {
            return false;
        }

        $slug = $validatedData['slug'];

        if (substr($slug, 0, 1) !== '/') {
            $slug = '/' . $slug;
        }        

        if (substr_count($slug, '/') >= 2) {
            $error = 'Veuillez Recommencer';
            return $error;
        }

        $checkSlug = QueryBuilder::table('page')
        ->select('COUNT(slug)')
        ->where('slug', '=', '%'.$slug.'%')
        ->get();

        if (!$page instanceof Page) {
            $page = Page::find($page['id']);
        }

        $page->setTitle($validatedData['title']);
        if ($checkSlug) {
            $count = count($checkSlug);
            $slug = $slug.'-'.$count;
            $page->setSlug($slug);
        } else {
            $page->setSlug($validatedData['slug']);
        }
        $page->setDescription($validatedData['description']);
        $page->setContent($validatedData['content']);
        $page->setUpdatedAt(date('Y-m-d H:i:s'));
        $page->update();

        $memento = new Memento();
        $memento->setTitle($validatedData['title']);
        $memento->setSlug($page->getSlug());
        $memento->setDescription($validatedData['description']);
        $memento->setContent($validatedData['content']);
        $memento->setCreatedAt(date('Y-m-d H:i:s'));
        $memento->setIdPage($page->getId());
        $memento->create();

        return true;
    }
}
