<?php

namespace App\Controllers\Front;

use App\Controllers\Controller;
use App\Core\QueryBuilder;
use App\Models\EmailActivationToken;
use App\Models\User;
use App\Requests\UserRequest;

class AccountController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function profileAction(): void
    {
        view('account/profile', 'account-settings', [
            'title' => 'Mon compte'
        ]);
    }

    public function otherAction(): void
    {
        view('account/other', 'account-settings', [
            'title' => 'Mon compte'
        ]);
    }

    public function verifyAccountAction(): void
    {
        $isAccountVerified = QueryBuilder::table('email_activation_token')
            ->select(['user.id'])
            ->join('user', function($join) {
                $join->on('user.id', '=', 'email_activation_token.id_user');
            })
            ->where('user.email', $_SESSION['login'])
            ->WhereNotNull('verified_at')
            ->exists();

        if ($isAccountVerified) {
            redirectHome();
        }

        view('account/verify-account', 'basic', [
            'title' => 'Activer mon compte'
        ]);
    }

    public function activateAccountAction($token): void
    {
        $EAT = EmailActivationToken::where('token', $token);

        if (!$EAT) {
            $this->redirectToVerificationPage();
        }

        $this->logout();

        if ($EAT->isVerified()) {
            view('account/already-verified', 'basic', [
                'title' => 'Lien invalide.'
            ]);
        }

        $EAT->setVerifiedAt(date('Y-m-d H:i:s.u'));
        $EAT->update();

        // TODO : voir pq même déconecté, le topbar de la vue possède une image de profil.
        view('account/verified-succesfully', 'basic', [
            'title' => 'Bienvenue !'
        ]);
    }

    private function logout(): void
    {
        session_destroy();
    }

    // TODO : mettre en place un temps d'attente minimum entre 2 envois
    public function resendMailAction(): void
    {
        $user = User::where('email', $_SESSION['login']);
        EmailActivationToken::sendActivationEmail($user);

        $this->redirectToVerificationPage();
    }

    public function showAction(): void
    {
        $user = QueryBuilder::table('user')
            ->select()
            ->where('email', $_SESSION['login'])
            ->first();

        $account = User::find($user['id']);

        if (!$account) {
            $this->redirectToProfile();
        }
        view('account/front/profile', 'account', [
            'account' => $account
        ]);
    }

    public function editAction(): void
    {
        $user = QueryBuilder::table('user')
            ->select()
            ->where('email', $_SESSION['login'])
            ->first();

        $account = User::find($user['id']);

        if (!$account) {
            $this->redirectToSetting();
        }

        view('account/front/setting', 'account', [
            'account' => $account
        ]);
    }

    public function updateAction(): void
    {
        $user = QueryBuilder::table('user')
            ->select()
            ->where('email', $_SESSION['login'])
            ->first();

        $account = User::find($user['id']);

        if (!$account) {
            $this->redirectToSetting();
        }

        $request = new UserRequest();

        $showPassword = isset($_POST['showPassword']) && $_POST['showPassword'];

        $_POST['showPassword'] = $showPassword;

        if (!$request->updateAccount($account)) {
            view('account/front/setting', 'account', [
                die(var_dump($request->getErrors())),
                'account' => $account,
                'errors' => $request->getErrors(),
                'old' => $request->getOld()
            ]);
            return;
        }

        $this->redirectToSetting();
    }

    private function redirectToSetting(): void
    {
        header('Location: /account/setting');
        exit();
    }

    private function redirectToProfile(): void
    {
        header('Location: /account/profile');
        exit();
    }

    private function redirectToVerificationPage(): void
    {
        header('Location: /verify-account');
        exit();
    }
}
