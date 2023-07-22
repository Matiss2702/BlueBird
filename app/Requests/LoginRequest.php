<?php

namespace App\Requests;

use App\Core\FormRequest;
use App\Models\User;

class LoginRequest extends FormRequest
{
    public function __construct()
    {
        parent::__construct($this->rules());
    }

    protected function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ];
    }

    protected function messages(): array
    {
        return [
            'email.required' => 'L\'adresse email est requise.',
            'email.email' => 'L\'adresse email doit être valide.',
            'password.required' => 'Le mot de passe est requis.',
            'password.min' => 'Le mot de passe doit contenir au moins 6 caractères.',
        ];
    }

    public function authenticate(): bool
    {
        $validatedData = $this->validate();

        if (!$validatedData) {
            return false;
        }

        $user = User::where('email', $validatedData['email']);

        if ($user && password_verify($validatedData['password'], $user->getPassword())) {
            $_SESSION['login'] = $user->getEmail();
            redirectHome();
        } else {
            $this->addError('form', 'Identifiants incorrects.');
            $this->setOldInput($validatedData);
            return false;
        }
    }
}
