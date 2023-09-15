<?php

namespace App\Requests;

use App\Core\FormRequest;
use App\Core\QueryBuilder;
use App\Models\ForgotPassword;
use App\Models\User;


class ForgotPasswordRequest extends FormRequest
{
    public function __construct()
    {
        parent::__construct($this->rules());
    }

    protected function rules(): array
    {
        return [
            'email' => 'required|email',
        ];
    }

    protected function messages(): array
    {
        return [
            'email.required' => 'L\'adresse email est requise.',
            'email.email' => 'L\'adresse email doit être valide.',
        ];
    }

    public function createPasswordChangeRequest(): bool
    {
        $validatedData = $this->validate();

        if (!$validatedData) {
            return false;
        }

        $email = $validatedData['email'];
        $user = User::where('email', $email);

        if (!$user || !$email) {
            $this->addError('form', 'Oops, nous n\'avons pas pu vous trouvé. Veuillez recommencer');
            return false;
        }

        ForgotPassword::sendRecoveryPassword($user);

        return true;
    }
}

