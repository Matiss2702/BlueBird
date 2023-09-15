<?php

namespace App\Requests;

use App\Models\User;
use App\Core\FormRequest;

class AccountRequest extends FormRequest
{
    protected $isCreating;

    public function __construct()
    {
        $this->isCreating = true;
        parent::__construct($this->rules());
    }

    protected function rules(): array
    {
        $rules = [
            'firstname' => 'required|string|max:60',
            'lastname' => 'required|string|max:60',
            'email' => 'required|string|max:100',
        ];

        if ($this->isCreating && isset($_POST['showPassword']) && $_POST['showPassword']) {
            $rules['password'] = 'required|string|max:50';
            $rules['confirmPassword'] = 'required|string|max:50|same:password';
        }

        return $rules;
    }

    protected function messages(): array
    {
        return [
            'firstname.required' => 'Le champ firstname est requis.',
            'firstname.string' => 'Le champ firstname doit être une chaîne de caractères.',
            'firstname.max' => 'Le champ firstname ne doit pas dépasser 60 caractères.',
            'lastname.required' => 'Le champ lastname est requis.',
            'lastname.string' => 'Le champ lastname doit être une chaîne de caractères.',
            'lastname.max' => 'Le champ lastname ne doit pas dépasser 60 caractères.',
            'email.required' => 'Le champ email est requis.',
            'email.string' => 'Le champ email doit être une chaîne de caractères.',
            'email.max' => 'Le champ email ne doit pas dépasser 100 caractères.',
            'password.string' => 'Le champ password doit être une chaîne de caractères.',
            'password.max' => 'Le champ password ne doit pas dépasser 50 caractères.',
            'confirmPassword.same' => 'Le champ confirmPassword doit être le même que le password',
            'confirmPassword.string' => 'Le champ confirmPassword doit être une chaîne de caractères.',
            'confirmPassword.max' => 'Le champ confirmPassword ne doit pas dépasser 50 caractères.',
        ];
    }

    public function createAccount(): bool
    {
        $validatedData = $this->validate();
        if (!$validatedData) {
            return false;
        }

        $user = new User();
        $user->setFirstname($validatedData['firstname']);
        $user->setLastname($validatedData['lastname']);
        $user->setEmail($validatedData['email']);
        $user->setPassword($validatedData['password']);
        $user->setStatus($validatedData['status']);
        $user->create();

        return true;
    }

    public function updateAccount(User $user): bool
    {
        $validatedData = $this->validate();

        if (!$validatedData) {
            return false;
        }

        $user->setFirstname($validatedData['firstname']);
        $user->setLastname($validatedData['lastname']);
        $user->setEmail($validatedData['email']);

       if (isset($_POST['showPassword']) && $_POST['showPassword']) {
            $user->setPassword($validatedData['password']);
        }

        $user->update();

        return true;
    }
}
