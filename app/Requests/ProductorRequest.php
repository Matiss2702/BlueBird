<?php

namespace App\Requests;

use App\Models\Productor;
use App\Core\FormRequest;

class ProductorRequest extends FormRequest
{
    public function __construct()
    {
        parent::__construct($this->rules());
    }

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:200',
            'description' => 'required|string|max:2000',
            'id_country' => 'required|integer',
        ];
    }

    protected function messages(): array
    {
        return [
            'name.required' => 'Le nom est requis.',
            'name.string' => 'Le nom doit être une chaîne de caractères.',
            'name.max' => 'Le nom ne doit pas dépasser 200 caractères.',
            'description.required' => 'La description est requise.',
            'description.string' => 'La description doit être une chaîne de caractères.',
            'description.max' => 'La description ne doit pas dépasser 200 caractères.',
            'id_country.required' => 'Le pays est requise.',
            'id_country.integer' => 'Le pays doit retourner un nombre.',
        ];
    }

    public function createProductor(): bool
    {
        $validatedData = $this->validate();

        if (!$validatedData) {
            return false;
        }

        $productor = new Productor();
        $productor->setName($validatedData['name']);
        $productor->setDescription($validatedData['description']);
        $productor->setIdCountry($validatedData['id_country']);
        $productor->create();

        return true;
    }

    public function updateProductor($productor): bool
    {
        $validatedData = $this->validate();

        if (!$validatedData) {
            return false;
        }

        if (!$productor instanceof Productor) {
            $productor = Productor::find($productor['id']);
        }

        $productor->setName($validatedData['name']);
        $productor->setDescription($validatedData['description']);
        $productor->setIdCountry($validatedData['id_country']);
        $productor->update();

        return true;
    }
}