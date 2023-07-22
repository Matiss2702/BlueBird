<?php
namespace App\Requests;

use App\Core\FormRequest;
use App\Models\EmailActivationToken;
use App\Models\User;

class RegisterRequest extends FormRequest
{
    public function __construct()
    {
        parent::__construct($this->rules());
    }

    protected function rules(): array
    {
        return [
            'firstname' => 'required|string|min:2|max:60',
            'lastname' => 'required|string|min:2|max:120',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'passwordConfirm' => 'required|same:password',
        ];
    }

    protected function messages(): array
    {
        return [
            'firstname.required' => 'Le champ prénom est requis.',
            'firstname.string' => 'Le champ prénom doit être une chaîne de caractères.',
            'firstname.min' => 'Le champ prénom doit contenir au moins 2 caractères.',
            'firstname.max' => 'Le champ prénom ne doit pas dépasser 60 caractères.',
            'lastname.required' => 'Le champ nom est requis.',
            'lastname.string' => 'Le champ nom doit être une chaîne de caractères.',
            'lastname.min' => 'Le champ nom doit contenir au moins 2 caractères.',
            'lastname.max' => 'Le champ nom ne doit pas dépasser 120 caractères.',
            'email.required' => 'L\'adresse email est requise.',
            'email.email' => 'L\'adresse email doit être valide.',
            'password.required' => 'Le mot de passe est requis.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.regex' => 'Le mot de passe doit contenir au moins une majuscule, une minuscule et un chiffre.',
            'passwordConfirm.required' => 'La confirmation du mot de passe est requise.',
            'passwordConfirm.same' => 'La confirmation du mot de passe ne correspond pas au mot de passe.',
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
        $userId = $user->create();

        $user->setId($userId);

        // Envoi du mail d'activation du compte
        EmailActivationToken::sendActivationEmail($user);

        $this->connect($userId);

        return true;
    }

    private function connect($userId): void
    {
        if (!$userId)
            return;

        $user = user::find($userId);

        if ($user) {
            $_SESSION['login'] = $user->getEmail();
            redirectHome();
        }
    }
}
