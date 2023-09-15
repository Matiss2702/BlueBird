<?php

namespace App\Controllers\Front;

use App\Controllers\Controller;
use App\Exceptions\HttpException;
use App\Models\ForgotPassword;
use App\Requests\ForgotPasswordRequest;
use App\Requests\ResetPasswordRequest;
use App\Core\QueryBuilder;


class ForgotPasswordController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function indexAction()
    {
        if (isConnected())
            $this->redirectToFPHome();

        view('forgot-password/front/index', 'front', [
            'title' => 'BlueBird | Mot de passe Oublié',
        ]);
    }

    public function storeAction():void
    {
        if (isConnected())
            $this->redirectToFPHome();

        $request = new ForgotPasswordRequest();

        if(!$request->createPasswordChangeRequest()){
            view('forgot-password/front/index', 'front', [
                'errors' => $request->getErrors(),
                'old' => $request->getOld(),
            ]);
        }

        $this->redirectToFPHome();
    }

    public function editAction($token): void
    {
        if (isConnected())
            $this->redirectToFPHome();

        $FP = ForgotPassword::where('token', $token);

        if (!$FP || $FP->isCompletedAt()) {
            throw new HttpException('Page Not Found', HTTP_NOT_FOUND);
        }

        view('forgot-password/front/edit', 'front', [
            'title' => 'BlueBird | Modification du mot de passe',
            'FP'    => $FP
        ]);
    }

    public function updateAction($token): void
    {
        if (isConnected())
            $this->redirectToFPHome();

        $FP = ForgotPassword::where('token', $token);
        $request = new ResetPasswordRequest();

        if (!$FP) {
            $this->redirectToFPHome();
        }

        if (!$request->updatePasswordUserFP($FP)) {
            view('forgot-password/front/edit', 'front', [
                'errors' => $request->getErrors(),
                'old'    => $request->getOld(),
                'FP'     => $FP,
            ]);
        }

        $this->redirectToFPHome();
    }

    public function invalidAction():void
    {
        view('forgot-password/front/invalid', 'front', [
            'title' => 'Bluebird | Lien invalide',
        ]);
    }

    private function redirectToFPHome(): void
    {
        header('Location: /forgot-password');
        exit();
    }

}
