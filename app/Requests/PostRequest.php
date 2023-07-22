<?php

namespace App\Requests;

use App\Models\Post;
use App\Core\FormRequest;

class PostRequest extends FormRequest
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

    public function createPost(): bool
    {
        $validatedData = $this->validate();

        if (!$validatedData) {
            return false;
        }

        $post = new Post();
        $post->setTitle($validatedData['title']);
        $post->setContent($validatedData['content']);
        $post->create();

        return true;
    }

    public function updatePost($post): bool
    {
        $validatedData = $this->validate();

        if (!$validatedData) {
            return false;
        }

        if (!$post instanceof Post) {
            $post = Post::find($post['id']);
        }

        $post->setTitle($validatedData['title']);
        $post->setContent($validatedData['content']);
        $post->update();

        return true;
    }
}
