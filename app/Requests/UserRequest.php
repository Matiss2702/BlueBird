<?php

namespace App\Requests;

use App\Models\User;
use App\Core\FormRequest;
use App\Core\QueryBuilder;

class UserRequest extends FormRequest
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
            'status' => 'in:0,1',
            'id_roles' => 'required',
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
            'status.required' => 'Le champ status est requis.',
            'id_roles.required' => 'Veuillez sélectionner au moins un rôle.',
            'password.string' => 'Le champ password doit être une chaîne de caractères.',
            'password.max' => 'Le champ password ne doit pas dépasser 50 caractères.',
            'confirmPassword.same' => 'Le champ confirmPassword doit être le même que le password',
            'confirmPassword.string' => 'Le champ confirmPassword doit être une chaîne de caractères.',
            'confirmPassword.max' => 'Le champ confirmPassword ne doit pas dépasser 50 caractères.',
        ];
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
        $user->setStatus($validatedData['status']);

        if (isset($_POST['showPassword']) && $_POST['showPassword']) {
            $user->setPassword($validatedData['password']);
        }

        $user->update();

        return true;
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
        $user->setStatus($validatedData['status']);
        $user->create();

        $this->syncUserRoles($user->getId(), $validatedData['id_roles']);

        return true;
    }

    public function updateUser($user): bool
    {

        $validatedData = $this->validate();

        if (!$validatedData) {
            return false;
        }

        if (!$user instanceof User) {
            $user = User::find($user['id']);
        }
        
        // echo '<pre>',
        // die(var_dump($validatedData));
        $user->setFirstname($validatedData['firstname']);
        $user->setLastname($validatedData['lastname']);
        $user->setEmail($validatedData['email']);
        $user->setStatus($validatedData['status']);

        if (isset($_POST['showPassword']) && $_POST['showPassword']) {
            $user->setPassword($validatedData['password']);
        }

        $user->update();

        $this->syncUserRoles($user->getId(), $validatedData['id_roles']);

        return true;
    }

    private function syncUserRoles($userId, $roleIds): void
    {
        $userRoles = QueryBuilder::table('user_role')
            ->select()
            ->where('id_user', '=', $userId)
            ->get();

        $userRoles = array_values(array_column($userRoles, 'id_role'));

        // Remove the role admin from the list if it's not selected
        if (!in_array(1, $roleIds) && in_array(1, $userRoles)) {
            $key = array_search(1, $userRoles);
            unset($userRoles[$key]);
        }

        $rolesToInsert = array_diff($roleIds, $userRoles);
        $rolesToDelete = array_diff($userRoles, $roleIds);

        foreach ($rolesToInsert as $roleId) {
            QueryBuilder::table('user_role')->insert([
                'id_user' => $userId,
                'id_role' => $roleId
            ]);
        }

        foreach ($rolesToDelete as $roleId) {
            QueryBuilder::table('user_role')
                ->where('id_user', '=', $userId)
                ->where('id_role', '=', $roleId)
                ->delete();
        }
    }
}