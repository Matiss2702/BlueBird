<?php

namespace App\Requests;

use App\Core\FormRequest;
use App\Models\TemplateOne;

class TemplateOneRequest extends FormRequest
{
    public function __construct()
    {
        parent::__construct($this->rules(), $this->messages());
    }

    protected function rules(): array
    {
        return [
            'title' => 'required|string',
            'subtitle' => 'required|string',
            'about_title' => 'required|string',
            'about_desc' => 'required|string',
            'about_img' => 'required|string',
            'main_bloc_title' => 'required|string',
            'main_bloc_desc' => 'required|string',
            'main_bloc_img' => 'required|string',
            'bloc_one_title' => 'required|string',
            'bloc_one_desc' => 'required|string',
            'bloc_one_img' => 'required|string',
            'bloc_two_title' => 'required|string',
            'bloc_two_desc' => 'required|string',
            'bloc_two_img' => 'required|string',
            'address' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
        ];
    }

    protected function messages(): array
    {
        return [
            'title.required' => 'Le champ titre est requis.',
            'title.string' => 'Le champ titre doit être une chaîne de caractères.',

            'subtitle.required' => 'Le champ sous-titre est requis.',
            'subtitle.string' => 'Le champ sous-titre doit être une chaîne de caractères.',

            'about_title.required' => 'Le champ titre de la section "À propos" est requis.',
            'about_title.string' => 'Le champ titre de la section "À propos" doit être une chaîne de caractères.',

            'about_desc.required' => 'Le champ description de la section "À propos" est requis.',
            'about_desc.string' => 'Le champ description de la section "À propos" doit être une chaîne de caractères.',

            'about_img.string' => 'Le champ image de la section "À propos" doit être une chaîne de caractères.',

            'main_bloc_title.required' => 'Le champ titre du bloc principal est requis.',
            'main_bloc_title.string' => 'Le champ titre du bloc principal doit être une chaîne de caractères.',

            'main_bloc_desc.required' => 'Le champ description du bloc principal est requis.',
            'main_bloc_desc.string' => 'Le champ description du bloc principal doit être une chaîne de caractères.',

            'main_bloc_img.string' => 'Le champ image du bloc principal doit être une chaîne de caractères.',

            'bloc_one_title.required' => 'Le champ titre du bloc un est requis.',
            'bloc_one_title.string' => 'Le champ titre du bloc un doit être une chaîne de caractères.',

            'bloc_one_desc.required' => 'Le champ description du bloc un est requis.',
            'bloc_one_desc.string' => 'Le champ description du bloc un doit être une chaîne de caractères.',

            'bloc_one_img.string' => 'Le champ image du bloc un doit être une chaîne de caractères.',

            'bloc_two_title.required' => 'Le champ titre du bloc deux est requis.',
            'bloc_two_title.string' => 'Le champ titre du bloc deux doit être une chaîne de caractères.',

            'bloc_two_desc.required' => 'Le champ description du bloc deux est requis.',
            'bloc_two_desc.string' => 'Le champ description du bloc deux doit être une chaîne de caractères.',

            'bloc_two_img.string' => 'Le champ image du bloc deux doit être une chaîne de caractères.',

            'address.required' => 'Le champ adresse est requis.',
            'address.string' => 'Le champ adresse doit être une chaîne de caractères.',

            'email.required' => 'Le champ email est requis.',
            'email.email' => 'Le champ email doit être une adresse email valide.',

            'phone.required' => 'Le champ téléphone est requis.',
            'phone.string' => 'Le champ téléphone doit être une chaîne de caractères.',
        ];
    }

    public function createTemplateOne(): bool
    {
        $validatedData = $this->validate();

        if (!$validatedData) {
            return false;
        }

        $slug = generateSlug($this->getRequest()->getPost('title'));

        if (TemplateOne::where('slug', $slug)) {
            $this->addError('title', 'Le titre est déja utilisé.');
            return false;
        }

        $templateOne = new TemplateOne();
        $templateOne->setSlug($slug);
        $templateOne->setTitle($validatedData['title']);
        $templateOne->setSubtitle($validatedData['subtitle']);
        $templateOne->setAboutTitle($validatedData['about_title']);
        $templateOne->setAboutDesc($validatedData['about_desc']);
        $templateOne->setAboutImg($validatedData['about_img']);
        $templateOne->setMainBlocTitle($validatedData['main_bloc_title']);
        $templateOne->setMainBlocDesc($validatedData['main_bloc_desc']);
        $templateOne->setMainBlocImg($validatedData['main_bloc_img']);
        $templateOne->setBlocOneTitle($validatedData['bloc_one_title']);
        $templateOne->setBlocOneDesc($validatedData['bloc_one_desc']);
        $templateOne->setBlocOneImg($validatedData['bloc_one_img']);
        $templateOne->setBlocTwoTitle($validatedData['bloc_two_title']);
        $templateOne->setBlocTwoDesc($validatedData['bloc_two_desc']);
        $templateOne->setBlocTwoImg($validatedData['bloc_two_img']);
        $templateOne->setAddress($validatedData['address']);
        $templateOne->setEmail($validatedData['email']);
        $templateOne->setPhone($validatedData['phone']);
        $templateOne->create();

        return true;
    }

    public function updateTemplateOne($templateOne): bool
    {
        $validatedData = $this->validate();

        if (!$validatedData) {
            return false;
        }

        $templateOne->setTitle($validatedData['title']);
        $templateOne->setSubtitle($validatedData['subtitle']);
        $templateOne->setAboutTitle($validatedData['about_title']);
        $templateOne->setAboutDesc($validatedData['about_desc']);
        $templateOne->setAboutImg($validatedData['about_img']);
        $templateOne->setMainBlocTitle($validatedData['main_bloc_title']);
        $templateOne->setMainBlocDesc($validatedData['main_bloc_desc']);
        $templateOne->setMainBlocImg($validatedData['main_bloc_img']);
        $templateOne->setBlocOneTitle($validatedData['bloc_one_title']);
        $templateOne->setBlocOneDesc($validatedData['bloc_one_desc']);
        $templateOne->setBlocOneImg($validatedData['bloc_one_img']);
        $templateOne->setBlocTwoTitle($validatedData['bloc_two_title']);
        $templateOne->setBlocTwoDesc($validatedData['bloc_two_desc']);
        $templateOne->setBlocTwoImg($validatedData['bloc_two_img']);
        $templateOne->setAddress($validatedData['address']);
        $templateOne->setEmail($validatedData['email']);
        $templateOne->setPhone($validatedData['phone']);
        $templateOne->update();

        return true;
    }

    public function editPostRequest($key, $val)
    {
        $this->getRequest()->setPost($key, $val);
    }
}
