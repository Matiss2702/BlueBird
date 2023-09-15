<?php

namespace App\Requests;

use App\Models\Menu;
use App\Core\FormRequest;

class MenuRequest extends FormRequest
{
    protected $uniquePk;

    public function __construct()
    {
        parent::__construct($this->rules());
    }

    protected function rules(): array
    {
        $rules = [
            'title' => 'required|string|max:60',
            'slug' => 'required|string|max:60',
            'orders' => 'required|integer|unique:menu',
            'zone' => 'in:0,1,2',
            'status' => 'in:0,1',
        ];

        return $rules;
    }

    protected function messages(): array
    {
        return [
            'title.required' => 'Le champ title est requis.',
            'title.string' => 'Le champ title doit être une chaîne de caractères.',
            'title.max' => 'Le champ title ne doit pas dépasser 60 caractères.',
            'slug.required' => 'Le champ slug est requis.',
            'slug.string' => 'Le champ slug doit être une chaîne de caractères.',
            'slug.max' => 'Le champ slug ne doit pas dépasser 60 caractères.',
            'orders.required' => 'Le champ orders est requis.',
            'orders.integer' => 'Le champ orders doit être un entier.',
            'orders.unique' => 'La valeur du champ orders est déjà utilisée par un autre menu !',
            'zone.integer' => 'Le champ zone doit être un entier.',
            'status.integer' => 'Le champ status doit être un booléen.',
        ];
    }

    public function createMenu(): bool
    {
        $validatedData = $this->validate();

        if (!$validatedData) {
            return false;
        }
        if ($validatedData['id_parent'] === 0) {
            $validatedData['id_parent'] = null;
        }

        $menu = new Menu();
        $menu->setTitle($validatedData['title']);
        $menu->setSlug($validatedData['slug']);
        $menu->setOrders(intval($validatedData['orders']));
        $menu->setParent($validatedData['id_parent']);
        $menu->setZone($validatedData['zone']);
        $menu->setStatus($validatedData['status']);
        $menu->create();

        return true;
    }

    public function updateMenu(Menu $menu): bool
    {
        $this->uniquePk = $menu->getId();
        $validatedData = $this->validate();

        if (!$validatedData) {
            return false;
        }

        $menu->setTitle($validatedData['title']);
        $menu->setSlug($validatedData['slug']);
        $menu->setOrders($validatedData['orders']);
        $menu->setParent($validatedData['id_parent']);
        $menu->setZone($validatedData['zone']);
        $menu->setStatus($validatedData['status']);
        $menu->update();

        return true;
    }
}