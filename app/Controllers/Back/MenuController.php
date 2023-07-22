<?php

namespace App\Controllers\Back;

use App\Controllers\Controller;
use App\Requests\MenuRequest;
use App\Core\View;
use App\Models\Menu;

class MenuController extends Controller
{
    public function listAction()
    {
        view('menu/back/list', 'back', [
            'menus' => Menu::all()
        ]);
    }

    public function createAction(): void
    {
        view('menu/back/create', 'back');
    }

    public function storeAction(): void
    {
        $request = new MenuRequest();

        if (!$request->createMenu()) {
            view('menu/back/create', 'back', [
                // die(var_dump($request->getErrors())),
                'errors' => $request->getErrors(),
                'old'    => $request->getOld()
            ]);
        }

        $this->redirectToList();
    }

    public function showAction($id): void
    {
        $menu = Menu::find($id);

        if (!$menu)
            $this->redirectToList();

        view('menu/back/show', 'back', [
            'menu' => $menu
        ]);
    }

    public function editAction($id): void
    {
        $menu = Menu::find($id);

        if (!$menu)
            $this->redirectToList();

        view('menu/back/edit', 'back', [
            'menu' => $menu
        ]);
    }

    public function updateAction($id): void
    {
        $menu = menu::find($id);

        if (!$menu) {
            $this->redirectToList();
        }

        $request = new MenuRequest();

        if (!$request->updateMenu($menu)) {
            view('menu/back/edit', 'back', [
                'menu'   => $menu,
                'errors' => $request->getErrors(),
                'old'    => $request->getOld()
            ]);
        }

        $this->redirectToList();
    }

    public function deleteAction($id): void
    {
        $menu = Menu::find($id);

        if ($menu) {
            $menu->delete();
        }

        $this->redirectToList();
    }

    private function redirectToList(): void
    {
        header('Location: /admin/menu/list');
        exit();
    }
}
