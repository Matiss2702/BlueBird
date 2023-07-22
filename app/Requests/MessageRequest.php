<?php

namespace App\Requests;

use App\Models\Message;
use App\Core\FormRequest;

class MessageRequest extends FormRequest
{
    public function __construct()
    {
        parent::__construct($this->rules());
    }

    protected function rules(): array
    {
        return [
            'object' => 'required|string|max:100',
            'message' => 'required|string|max:255',
            'firstname' => 'required|string|max:60',
            'lastname' => 'required|string|max:60',
            'email' => 'required|string|max:100',
            'id_categorie_message' => 'required|integer',
        ];
    }

    protected function messages(): array
    {
        return [
            'object.required' => 'Le champ "Object" est requis.',
            'object.string' => 'Le champ "Object" doit être une chaîne de caractères.',
            'object.max' => 'Le champ "Object" ne doit pas dépasser 100 caractères.',
            'message.required' => 'Le champ "Message" est requis.',
            'message.string' => 'Le champ "Message" doit être une chaîne de caractères.',
            'message.max' => 'Le champ "Message" ne doit pas dépasser 255 caractères.',
            'firstname.required' => 'Le champ "Prénom" est requis.',
            'firstname.string' => 'Le champ "Prénom" doit être une chaîne de caractères.',
            'firstname.max' => 'Le champ "Prénom" ne doit pas dépasser 60 caractères.',
            'lastname.required' => 'Le champ "Nom" est requis.',
            'lastname.string' => 'Le champ "Nom" doit être une chaîne de caractères.',
            'lastname.max' => 'Le champ "Nom" ne doit pas dépasser 60 caractères.',
            'email.required' => 'Le champ "Email" est requis.',
            'email.string' => 'Le champ "Email" doit être une chaîne de caractères.',
            'email.max' => 'Le champ "Email" ne doit pas dépasser 100 caractères.',
            'id_categorie_message.required' => 'Le champ "ID Catégorie Message" est requis.',
            'id_categorie_message.integer' => 'Le champ "ID Catégorie Message" doit être une chaîne de caractères.',
        ];
    }

    public function createMessage(): bool
    {
        $validatedData = $this->validate();

        if (!$validatedData) {
            return false;
        }

        $message = new Message();
        $message->setObject($validatedData['object']);
        $message->setMessage($validatedData['message']);
        $message->setFirstname($validatedData['firstname']);
        $message->setLastname($validatedData['lastname']);
        $message->setEmail($validatedData['email']);
        $message->setIdCategorieMessage($validatedData['id_categorie_message']);
        $message->create();

        return true;
    }

    public function updateMessage($message): bool
    {
        $validatedData = $this->validate();

        if (!$validatedData) {
            return false;
        }

        if (!$message instanceof Message) {
            $message = Message::find($message['id']);
        }

        $message->setObject($validatedData['object']);
        $message->setMessage($validatedData['message']);
        $message->setFirstname($validatedData['firstname']);
        $message->setLastname($validatedData['lastname']);
        $message->setEmail($validatedData['email']);
        $message->setIdCategorieMessage($validatedData['id_categorie_message']);
        $message->update();

        return true;
    }
}
