<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-8 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Récupération du mot de passe</h1>
                        </div>
                        <form class="forgot-password" action="/forgot-password/update/<?=$FP->getToken()?>" method="POST">
                            <div class="form-group">
                                <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Votre mot de passe" required>
                                <?php if(isset($errors['password'])): ?>
                                    <?php foreach($errors['password'] as $error): ?>
                                        <div class="alert alert-danger my-3 small" role="alert">
                                            <?= $error ?>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control form-control-user" id="passwordConfirm" name="passwordConfirm" placeholder="Confirmer votre mot de passe" required>
                                <?php if (isset($errors['passwordConfirm'])) : ?>
                                    <?php foreach ($errors['passwordConfirm'] as $error): ?>
                                        <div class="alert alert-danger my-3 small" role="alert">
                                            <?= $error ?>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                Modifier mon mot de passe
                            </button>
                        </form>
                        <?php if (isset($errors['form'])): ?>
                            <?php foreach($errors['form'] as $error): ?>
                                <hr>
                                <div class="alert alert-danger my-3 small" role="alert">
                                    <?= $error ?>
                                </div>
                                <div class="text-center pb-2">
                                    <a href="/forgot-password/">Mot de passe oublié ?</a>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
