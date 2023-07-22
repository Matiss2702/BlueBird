<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-8 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Inscrivez-vous en 30 secondes!</h1>
                        </div>
                        <form class="user" action="/register" method="POST">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="firstname" name="firstname" placeholder="Votre prénom" required>
                                <?php if(isset($errors['firstname'])): ?>
                                    <?php foreach($errors['firstname'] as $error): ?>
                                        <div class="alert alert-danger my-3 small" role="alert">
                                            <?= $error ?>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="lastname" name="lastname" placeholder="Votre nom" required>
                                <?php if(isset($errors['lastname'])): ?>
                                    <?php foreach($errors['lastname'] as $error): ?>
                                        <div class="alert alert-danger my-3 small" role="alert">
                                            <?= $error ?>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control form-control-user" id="email" name="email" placeholder="Votre email" required>
                                <?php if(isset($errors['email'])): ?>
                                    <?php foreach($errors['email'] as $error): ?>
                                        <div class="alert alert-danger my-3 small" role="alert">
                                            <?= $error ?>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
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
                                <?php if(isset($errors['passwordConfirm'])): ?>
                                    <?php foreach($errors['passwordConfirm'] as $error): ?>
                                        <div class="alert alert-danger my-3 small" role="alert">
                                            <?= $error ?>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                Nous rejoindre
                            </button>
                        </form>
                        <hr>
                        <div class="text-center small">
                            Déjà un compte ? <a href="/login">Connectez-vous</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
