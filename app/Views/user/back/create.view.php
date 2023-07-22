<div class="card w-100 mb-3">
    <div class="card-header d-flex">
        <h4 class="card-title">Nouvel Utilisateur</h4>
        <a href="/admin/user/list" class="btn btn-primary ml-auto">
            <span class="icon text-white-50">
                <i class="fa fa-arrow-left"></i>
            </span>
            <span class="text">Revenir à la liste</span>
        </a>
    </div>
    <div class="container mt-5">
        <div class="w-75">
            <form action="/admin/user/store" method="POST">
                <div class="form-group">
                    <label for="firstname">Prénom</label>
                    <input type="text" id="firstname" name="firstname" class="form-control" value="<?= $old->firstname ?? '' ?>">
                    <?php if(isset($errors['firstname'])): ?>
                        <?php foreach($errors['firstname'] as $error): ?>
                            <div class="text-danger"><?= $error; ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="lastname">Nom</label>
                    <input type="text" id="lastname" name="lastname" class="form-control" value="<?= $old->lastname ?? '' ?>">
                    <?php if(isset($errors['lastname'])): ?>
                        <?php foreach($errors['lastname'] as $error): ?>
                            <div class="text-danger"><?= $error; ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" class="form-control" value="<?= $old->email ?? '' ?>">
                    <?php if(isset($errors['email'])): ?>
                        <?php foreach($errors['email'] as $error): ?>
                            <div class="text-danger"><?= $error; ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" class="form-control" value="<?= $old->password ?? '' ?>">
                    <?php if(isset($errors['password'])): ?>
                        <?php foreach($errors['password'] as $error): ?>
                            <div class="text-danger"><?= $error; ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="passwordConfirm">Confirmer le mot de passe</label>
                    <input type="password" id="passwordConfirm" name="passwordConfirm" class="form-control" value="<?= $old->passwordConfirm ?? '' ?>">
                    <?php if(isset($errors['passwordConfirm'])): ?>
                        <?php foreach($errors['passwordConfirm'] as $error): ?>
                            <div class="text-danger"><?= $error; ?></div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="status">Statut</label>
                        <select id="status" name="status" class="form-control">
                            <option value="0" <?= isset($old->status) && intval($old->status) === 0 ? 'selected' : '' ?>>Inactif</option> 
                            <option value="1" <?= isset($old->status) && intval($old->status) === 1 ? 'selected' : '' ?>>Actif</option>
                        </select>
                        <?php if(isset($errors['status'])): ?>
                            <?php foreach($errors['status'] as $error): ?>
                                <div class="text-danger"><?= $error; ?></div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </form>
        </div>
    </div>
</div>
