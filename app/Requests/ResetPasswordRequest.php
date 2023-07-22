<?php

namespace App\Requests;

use App\Core\FormRequest;
use App\Models\ForgotPassword;
use App\Models\User;


class ResetPasswordRequest extends FormRequest
{
    public function __construct()
    {
        parent::__construct($this->rules());
    }

    protected function rules(): array
    {
        return [
            'password' => 'required|min:3|max:255',
            'passwordConfirm' => 'required|same:password',
        ];
    }

    protected function messages(): array
    {
        return [
            'password.required' => 'Le mot de passe est requis.',
            'password.max' => 'Le mot de passe ne doit pas dépasser 255 caractères.',
            'password.min' => 'Le mot de passe ne doit pas dépasser 3 caractères.',
            'passwordConfirm.same' => 'Votre mot de passe ne correspond pas',
        ];
    }

    public function updatePasswordUserFP(ForgotPassword $FP): bool
    {
        $validatedData = $this->validate();

        if (!$validatedData) {
            return false;
        }

        $date_now = strtotime(date('Y-m-d H:i:s'));
        $send_at = strtotime($FP->getSendAt());
        $diff_minutes = round(abs(($date_now - $send_at) / 60));

        if($diff_minutes > 10){
            $this->addError('form', 'Oops, vous n\'avez plus la possibilité de modifier votre mot de passe');
            return false;
        }

        $FP->setCompletedAt(date('Y-m-d H:i:s'));
        $FP->update();

        $user = User::find($FP->getIdUser());
        $user->setPassword($validatedData['password']);
        $user->setUpdatedAt(date('Y-m-d H:i:s'));
        $user->update();
        view('forgot-password/front/success', 'front', [
            'title' => 'BlueBird | Modification de mot de passe réussie',
        ]);
        return true;

    }
}