<?php

namespace App\Requests;

use App\Core\FormRequest;
use App\Models\EmailActivationToken;
use App\Models\User;
use App\Models\UserRole;

class AdminAccountSetupRequest extends FormRequest
{
    public function __construct()
    {
        parent::__construct($this->rules());
    }

    protected function rules(): array
    {
        return [
            'lastname' => 'required|string|min:2|max:60',
            'firstname' => 'required|string|min:2|max:60',
            'email' => 'required|email',
            'password' => 'required|string|min:8|max:60',
            'passwordConfirm' => 'required|same:password',
        ];
    }

    protected function messages(): array
    {
        return [
            'lastname.required' => 'Le nom est requis.',
            'lastname.string' => 'Le nom doit être une chaîne de caractères.',
            'lastname.max' => 'Le nom ne doit pas dépasser 60 caractères.',
            'lastname.min' => 'Le nom doit contenir au moins 2 caractères.',
            'firstname.required' => 'Le nom est requis.',
            'firstname.string' => 'Le nom doit être une chaîne de caractères.',
            'firstname.max' => 'Le nom ne doit pas dépasser 60 caractères.',
            'firstname.min' => 'Le nom doit contenir au moins 2 caractères.',
            'email.required' => "L'email est obligatoire",
            'email.email' => "L'email n'est pas valide",
            'password.required' => 'Le mot de passe est requis.',
            'password.password' => 'Le mot de passe n\'est pas valide.',
            'password.max' => 'Le mot de passe ne doit pas dépasser 60 caractères.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'passwordConfirm.required' => 'Le mot de passe est requis.',
            'passwordConfirm.same' => 'Vos mots de passe ne sont pas identiques.',
        ];
    }

    public function createUser(): bool
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
        $user->setStatus(1);
        $user = $user->create();

        $user = User::find($user);
        // TODO LOTFI : Envoyer un mail au user, verifier le token automatiquement et mettre le role 1 (admin) par default
        // EmailActivationToken::sendActivationEmail($user);
        // EmailActivationToken::verifyTokenSetup($user);
        
        $userRole = new UserRole;
        $userRole ->setIdUser($user->getId());
        $userRole ->setIdRole(1);
        $userRole->create();

        return true;
    }
}