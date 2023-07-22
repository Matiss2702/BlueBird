<?php

namespace App\Controllers;
use App\Requests\UserRequest;
use App\Core\View;
use App\Models\User;
use App\Models\Role;
use App\Models\UserRole;
use App\Core\QueryBuilder;

class UserController extends Controller
{


    public function listAction()
    {
        $scripts =  [
            '/js/datatables/datatables.min.js',
            '/js/datatables/index.js',
            '/js/datatables/user-list.js',
        ];

        view('user/back/list', 'back', [
            'users' => User::all()
        ], $scripts);
    }

    public function createAction(): void
    {
        view('user/back/create', 'back');
    }

    public function storeAction(): void
    {
        $request = new UserRequest();

        if (!$request->createUser()) {
            view('user/back/create', 'back', [
                'errors' => $request->getErrors(),
                'old'    => $request->getOld()
            ]);
        }

        $this->redirectToList();
    }

    public function showAction($id): void
    {
        $user = User::find($id);

        if (!$user)
            $this->redirectToList();

        view('user/back/show', 'back', [
            'user' => $user
        ]);
    }

    public function editAction($id): void
    {
        $user = User::find($id);

        $roles = QueryBuilder::table('role')
            ->select()
            ->where('id', '<>', '1')
            ->get();

        $userRoles = QueryBuilder::table('user_role')
            ->select()
            ->join('role', function($join) {
                $join->on('role.id', '=', 'user_role.id_role');
            })
            ->where('user_role.id_user', $id)
            ->where('user_role.id_role', '<>', '1')
            ->get();
        
        $userRoles = array_values(array_column($userRoles, 'id_role'));

        if (!$user) {
            $this->redirectToList();
        }

        view('user/back/edit', 'back', [
            'user' => $user,
            'roles' => $roles,
            'userRoles' => $userRoles,
        ]);
    }

    public function updateAction($id): void
    {
        $user = User::find($id); 
        $request = new UserRequest();
       
        if (!$user) {
            $this->redirectToList();
        }
        
        if (!$request->updateUser($user)) {
            die(var_dump($request->getErrors()));
            view('user/back/edit', 'back', [
                'user'   => $user,
                'errors' => $request->getErrors(),
                'old'    => $request->getOld(),
            ]);
        }

        $this->redirectToList();
    }

    public function deleteAction($id): void
    {
        $user = User::find($id);

        if ($user) {
            $user->delete();
        }

        $this->redirectToList();
    }

    private function redirectToList(): void
    {
        header('Location: /admin/user/list');
        exit();
    }
}
