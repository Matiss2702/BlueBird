<div class="card w-100 mb-3">
    <div class="card-header d-flex">
        <h4 class="card-title">Détails du Message #<?= $message['id'] ?></h4>
        <a href="/admin/message/list" class="btn btn-primary ml-auto">
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
                    <label for="object">Objet</label>
                    <input type="text" class="form-control" value="<?= $message['object'] ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea class="form-control" readonly><?= $message['message'] ?></textarea>
                </div>
                <div class="form-group">
                    <label for="firstname">Prénom</label>
                    <input class="form-control" readonly value="<?= $message['firstname'] ?>">
                </div>
                <div class="form-group">
                    <label for="lastname">Nom</label>
                    <input class="form-control" readonly value="<?= $message['lastname'] ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input class="form-control" readonly value="<?= $message['email'] ?>">
                </div>
                <div class="form-group">
                    <label for="category">Catégorie</label>
                    <input type="text" class="form-control" readonly value="<?= $message['description'] ?>">
                </div>
            </form>
        </div>
    </div>
</div>