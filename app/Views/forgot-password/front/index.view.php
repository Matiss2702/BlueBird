<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-8 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Vous avez perdu votre mot de passe ?</h1>
                        </div>
                        <div class="my-auto">
                            <p>Recherchez votre adresse email</p>
                        </div>
                        <form class="forgot-password" action="/forgot-password/store" method="POST">
                            <div class="form-group">
                                <input type="email" class="form-control form-control-user" id="email" name="email" placeholder="Adresse email" value="<?= $old->email ?? '' ?>" required>
                                <?php if(isset($errors['email'])): ?>
                                    <?php foreach($errors['email'] as $error): ?>
                                        <div class="alert alert-danger my-3 small" role="alert">
                                            <?= $error ?>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                            <?php if (isset($errors['form'])): ?>
                                <?php foreach($errors['form'] as $error): ?>
                                    <div class="alert alert-danger my-3 small" role="alert">
                                        <?= $error ?>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                Vérifier mon Email
                            </button>
                        </form>
                        <hr>
                        <div class="text-center pb-2">
                            Déjà un compte ? <a href="/login">Se connecter</a>
                        </div>
                        <div class="text-center small">
                            Pas de compte ? <a href="/register">Inscrivez-vous</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
