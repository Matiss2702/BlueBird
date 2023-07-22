<div class="card w-100 mb-3">
    <div class="card-header d-flex">
        <h4 class="card-title">Détails de l'utilisateur #<?= $user->getId() ?></h4>
        <a href="/admin/user/list" class="btn btn-primary ml-auto">
            <span class="icon text-white-50">
                <i class="fa fa-arrow-left"></i>
            </span>
            <span class="text">Revenir à la liste</span>
        </a>
    </div>
    <div class="container mt-5">
        <div class="w-75">
            <form>
                <div class="form-group">
                    <label for="firstname">Prénom</label>
                    <input type="text" id="firstname" name="firstname" class="form-control" value="<?= $user->getFirstname() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="lastname">Nom</label>
                    <input type="text" id="lastname" name="lastname" class="form-control" value="<?= $user->getLastname() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="<?= $user->getEmail() ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" class="form-control" value="********" readonly>
                </div>
                <div class="form-group">
                    <label for="status">Statut</label>
                    <input type="text" id="status" name="status" class="form-control" value="<?= $user->getStatus() ? 'Actif' : 'Inactif' ?>" readonly>
                </div>
            </form>
        </div>
    </div>
</div>
