<?php

namespace App\Controllers\Back;

use App\Controllers\Controller;
use App\Core\QueryBuilder;
use App\Models\Productor;
use App\Models\Country;
use App\Requests\ProductorRequest;

class ProductorController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function listAction(): void
    {
        $scripts =  [
            '/js/datatables/datatables.min.js',
            '/js/datatables/index.js',
            '/js/datatables/productor-list.js',
        ];

        $productors = QueryBuilder::table('productor')
            ->select(
                'productor.*',
                'country.iso',
            )
            ->join('country', function($join) {
                $join->on('productor.id_country', '=', 'country.id');
            })
            ->orderBy('productor.name')
            ->get();

        view('productor/back/list', 'back', [
            'productors' => $productors
        ], $scripts);
    }

    public function createAction(): void
    {
        $countries = Country::all();

        view('productor/back/create', 'back', [
            'countries' => $countries
        ]);
    }

    public function storeAction(): void
    {
        $countries = Country::all();
        $request = new ProductorRequest();

        if (!$request->createProductor()) {
            view('productor/back/create', 'back', [
                'errors' => $request->getErrors(),
                'old'    => $request->getOld(),
                'countries' => $countries
            ]);
        }

        $this->redirectToList();
    }

    public function showAction($id): void
    {
        $productor = QueryBuilder::table('productor')
            ->select(
                'productor.id AS id_productor',
                'productor.name AS productor_name',
                'productor.*',
                'country.*',
            )
            ->join('country', function($join) {
                $join->on('productor.id_country', '=', 'country.id');
            })
            ->where('productor.id', $id)
            ->first();

        if (!$productor)
            $this->redirectToList();

        view('productor/back/show', 'back', [
            'productor' => $productor
        ]);
    }

    public function editAction($id): void
    {
        $productor = Productor::find($id);
        $countries = Country::all();

        if (!$productor)
            $this->redirectToList();    

        view('productor/back/edit', 'back', [
            'productor' => $productor,
            'countries'   => $countries
        ]);
    }

    public function updateAction($id): void
    {
        $productor = Productor::find($id);
        $countries = Country::all();
        $request = new ProductorRequest();

        if (!$productor) {
            $this->redirectToList();
        }

        if (!$request->updateProductor($productor)) {
            view('productor/back/edit', 'back', [
                'productor' => $productor,
                'countries'   => $countries,
                'errors'    => $request->getErrors(),
                'old'       => $request->getOld()
            ]);
        }

        $this->redirectToList();
    }

    public function deleteAction($id): void
    {
        $productor = Productor::find($id);

        if ($productor) {
            $productor->delete();
        }

        $this->redirectToList();
    }

    private function redirectToList(): void
    {
        header('Location: /admin/productor/list');
        exit();
    }
}