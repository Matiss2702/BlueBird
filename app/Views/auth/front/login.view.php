<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-8 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Connectez-vous</h1>
                        </div>
                        <form class="user" action="/login" method="POST">
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
                            <div class="form-group">
                                <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Mot de passe" required>
                                <?php if(isset($errors['password'])): ?>
                                    <?php foreach($errors['password'] as $error): ?>
                                        <div class="alert alert-danger my-3 small" role="alert">
                                            <?= $error ?>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox small">
                                    <input type="checkbox" class="custom-control-input" id="customCheck">
                                    <label class="custom-control-label" for="customCheck">Se souvenir de moi</label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                Se connecter
                            </button>
                        </form>
                        <?php if(isset($errors['form'])): ?>
                            <?php foreach($errors['form'] as $error): ?>
                                <div class="alert alert-danger my-3 small" role="alert">
                                    <?= $error ?>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <hr>
                        <div class="text-center">
                            <a class="small" href="/forgot-password">Mot de passe oublié ?</a>
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
